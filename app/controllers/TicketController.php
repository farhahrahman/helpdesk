<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
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
    private UserRepository $userRepo;
    private AuditService $auditService;

    public function __construct(
        ?TicketService $ticketService = null,
        ?TicketRepository $ticketRepo = null,
        ?AssetService $assetService = null,
        ?AssetRepository $assetRepo = null,
        ?UserRepository $userRepo = null,
        ?AuditService $auditService = null
    ) {
        $this->ticketService = $ticketService ?? new TicketService();
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->assetService = $assetService ?? new AssetService();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->auditService = $auditService ?? new AuditService();
    }

    /**
     * Ticket Listing with Search & Filters (Requires Login to View History)
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
            'pageTitle' => 'Sejarah Permohonan ICT - ' . app_config('app.short_name'),
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
     * Store New Request (Boleh Hantar Terus Tanpa Login)
     */
    public function store(Request $request): void
    {
        $data = $request->all();

        // Basic validation
        if (empty($data['title']) || empty($data['start_date'])) {
            Session::flashInput($data);
            $this->redirect('/tickets/create', 'error', 'Sila lengkapkan tajuk program dan tarikh permohonan.');
        }

        // Tentukan identiti pengguna (Staf log masuk ATAU Pemohon Terbuka)
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            // Pengguna awam / tetamu: semak maklumat wajib
            if (empty($data['applicant_name']) || empty($data['applicant_email'])) {
                Session::flashInput($data);
                $this->redirect('/tickets/create', 'error', 'Sila lengkapkan nama penuh dan emel rasmi pemohon.');
            }

            $email = strtolower(trim((string)$data['applicant_email']));
            $existingUser = $this->userRepo->findByEmail($email);

            if ($existingUser) {
                $user = $existingUser;
            } else {
                // Daftar automatik akaun staf dengan kata laluan asas '123456'
                $user = $this->userRepo->create([
                    'email' => $email,
                    'name' => trim((string)$data['applicant_name']),
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'role' => 'STAF',
                    'unit' => $data['unit'] ?? 'PENTADBIRAN',
                    'position' => trim((string)($data['applicant_position'] ?? 'Pegawai')),
                    'phone' => trim((string)($data['applicant_phone'] ?? '')),
                    'is_active' => true,
                ]);
            }
        }

        try {
            $ticket = $this->ticketService->createTicket($data, $user);
            Session::clearOldInput();

            if (Auth::check()) {
                $this->redirect(
                    "/tickets/{$ticket['id']}",
                    'success',
                    "Permohonan berjaya dihantar dengan No. Rujukan: {$ticket['reference_no']}"
                );
            } else {
                // Tetamu: Arahkan ke laman penjejakan status tiket awam bersama mesej rujukan
                $this->redirect(
                    "/track?ref=" . urlencode($ticket['reference_no']),
                    'success',
                    "Permohonan anda telah berjaya dihantar dengan No. Rujukan: {$ticket['reference_no']}! Sila simpan no. rujukan ini untuk semakan status, atau log masuk (kata laluan asas: 123456) untuk melihat sejarah permohonan."
                );
            }
        } catch (\Exception $e) {
            Session::flashInput($data);
            $this->redirect('/tickets/create', 'error', 'Ralat semasa memproses permohonan: ' . $e->getMessage());
        }
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
