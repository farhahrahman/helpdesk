<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;
use App\Services\AssetService;
use App\Services\AuditService;
use App\Services\TicketService;
use App\ViewModels\AssetViewModel;
use App\ViewModels\TicketViewModel;

/**
 * Ticket Controller
 */
class TicketController extends BaseController
{
    private TicketService $ticketService;
    private TicketRepository $ticketRepo;
    private AssetService $assetService;
    private AssetRepository $assetRepo;
    private AuditService $auditService;

    public function __construct(
        ?TicketService $ticketService = null,
        ?TicketRepository $ticketRepo = null,
        ?AssetService $assetService = null,
        ?AssetRepository $assetRepo = null,
        ?AuditService $auditService = null
    ) {
        $this->ticketService = $ticketService ?? new TicketService();
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->assetService = $assetService ?? new AssetService();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->auditService = $auditService ?? new AuditService();
    }

    /**
     * Ticket Listing with Search & Filters
     */
    public function index(Request $request): void
    {
        $user = Auth::user();
        $role = $user['role'] ?? 'STAF';
        $page = (int) $request->input('page', 1);

        $filters = [
            'search' => (string) $request->input('search', ''),
            'status' => (string) $request->input('status', ''),
            'category' => (string) $request->input('category', ''),
            'unit' => (string) $request->input('unit', ''),
        ];

        // Scope by RBAC
        if ($role === 'STAF') {
            $filters['user_id'] = $user['id'];
        } elseif ($role === 'KETUA_UNIT' && empty($filters['unit'])) {
            $filters['unit'] = $user['unit'];
        }

        $paginated = $this->ticketRepo->getFilteredTickets($filters, $page, 10);
        $paginated['data'] = TicketViewModel::presentCollection($paginated['data']);

        $this->render('tickets/index', [
            'pageTitle' => 'Senarai Permohonan ICT - ' . app_config('app.short_name'),
            'paginated' => $paginated,
            'filters' => $filters,
            'statuses' => app_config('roles.statuses', []),
            'categories' => app_config('services.categories', []),
            'units' => app_config('units', []),
        ]);
    }

    /**
     * Show New Request Form (Accessible to Public & Logged In Staff)
     */
    public function create(Request $request): void
    {
        $availableAssets = $this->assetRepo->getAvailableAssets();
        $isLoggedIn = Auth::check();
        $layout = $isLoggedIn ? 'app' : 'public';

        $this->render('tickets/create', [
            'pageTitle' => 'Borang Permohonan Perkhidmatan ICT - ' . app_config('app.short_name'),
            'categories' => app_config('services.categories', []),
            'equipmentTypes' => app_config('services.equipment_types', []),
            'meetingTypes' => app_config('services.meeting_support_types', []),
            'meetingPlatforms' => app_config('services.meeting_platforms', []),
            'meetingVenues' => app_config('services.meeting_venues', []),
            'mediaScopes' => app_config('services.media_scopes', []),
            'units' => app_config('units', []),
            'availableAssets' => AssetViewModel::presentCollection($availableAssets),
        ], $layout);
    }

    /**
     * Store New Request (With Smart Login Gateway for Guests)
     */
    public function store(Request $request): void
    {
        $data = $request->all();

        // Basic validation
        if (empty($data['title']) || empty($data['start_date'])) {
            Session::flashInput($data);
            $this->redirect('/tickets/create', 'error', 'Sila lengkapkan tajuk program dan tarikh permohonan.');
        }

        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            try {
                $ticket = $this->ticketService->createTicket($data, $user);
                Session::clearOldInput();
                $this->redirect(
                    "/tickets/{$ticket['id']}",
                    'success',
                    "Permohonan berjaya dihantar dengan No. Rujukan: {$ticket['reference_no']}"
                );
            } catch (\Exception $e) {
                Session::flashInput($data);
                $this->redirect('/tickets/create', 'error', 'Ralat semasa memproses permohonan: ' . $e->getMessage());
            }
            return;
        }

        // If NOT logged in: Save form draft into session and direct to login
        Session::set('_pending_ticket', $data);
        Session::flash('info', 'Borang permohonan telah disimpan! Sila log masuk ke akaun anda untuk menjana No. Tiket rasmi secara automatik.');
        $this->redirect('/login');
    }

    /**
     * Show Ticket Details & Workflow Action Area
     */
    public function show(Request $request, string $id): void
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->abort(404, 'Permohonan tidak dijumpai.');
        }

        $user = Auth::user();
        // Permission check
        if ($user['role'] === 'STAF' && $ticket['user_id'] !== $user['id']) {
            $this->abort(403, 'Akses dinafikan. Anda hanya boleh melihat permohonan sendiri.');
        } elseif ($user['role'] === 'KETUA_UNIT' && $ticket['unit'] !== $user['unit'] && $ticket['user_id'] !== $user['id']) {
            $this->abort(403, 'Akses dinafikan. Permohonan ini bukan di bawah unit anda.');
        }

        $presented = TicketViewModel::present($ticket);
        $auditTrail = $this->auditService->getTrailForTicket($id);

        // Fetch assigned asset objects
        $assignedAssets = [];
        foreach ($ticket['assigned_asset_ids'] ?? [] as $assetId) {
            $a = $this->assetRepo->find($assetId);
            if ($a) {
                $assignedAssets[] = AssetViewModel::present($a);
            }
        }

        // Available assets for ICT assignment
        $allAssets = $this->assetRepo->all();
        $availableForAssignment = AssetViewModel::presentCollection($allAssets);

        $this->render('tickets/show', [
            'pageTitle' => "Permohonan {$ticket['reference_no']} - " . app_config('app.short_name'),
            'ticket' => $presented,
            'auditTrail' => $auditTrail,
            'assignedAssets' => $assignedAssets,
            'availableAssets' => $availableForAssignment,
            'ictStaff' => (new \App\Repositories\UserRepository())->getICTStaff(),
        ]);
    }

    /**
     * Printable Official Slip / Handover Form
     */
    public function printSlip(Request $request, string $id): void
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->abort(404, 'Permohonan tidak dijumpai.');
        }

        $presented = TicketViewModel::present($ticket);

        $assignedAssets = [];
        foreach ($ticket['assigned_asset_ids'] ?? [] as $assetId) {
            $a = $this->assetRepo->find($assetId);
            if ($a) {
                $assignedAssets[] = AssetViewModel::present($a);
            }
        }

        $this->render('tickets/print', [
            'pageTitle' => "Borang Permohonan & Serahan Aset - {$ticket['reference_no']}",
            'ticket' => $presented,
            'assignedAssets' => $assignedAssets,
        ], 'print');
    }

    /**
     * Cancel Ticket
     */
    public function cancel(Request $request, string $id): void
    {
        $reason = (string) $request->input('reason', 'Dibatalkan oleh pemohon');
        $user = Auth::user();

        $success = $this->ticketService->cancelTicket($id, $reason, $user);

        if ($success) {
            $this->redirect("/tickets/{$id}", 'info', 'Permohonan telah berjaya dibatalkan.');
        } else {
            $this->redirect("/tickets/{$id}", 'error', 'Permohonan tidak dapat dibatalkan.');
        }
    }
}
