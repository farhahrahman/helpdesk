<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Services\ApprovalService;
use App\Services\AssetService;
use App\ViewModels\TicketViewModel;

/**
 * Approval & Workflow Controller
 */
class ApprovalController extends BaseController
{
    private ApprovalService $approvalService;
    private AssetService $assetService;
    private TicketRepository $ticketRepo;
    private AssetRepository $assetRepo;
    private UserRepository $userRepo;

    public function __construct(
        ?ApprovalService $approvalService = null,
        ?AssetService $assetService = null,
        ?TicketRepository $ticketRepo = null,
        ?AssetRepository $assetRepo = null,
        ?UserRepository $userRepo = null
    ) {
        $this->approvalService = $approvalService ?? new ApprovalService();
        $this->assetService = $assetService ?? new AssetService();
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    /**
     * Approvals Inbox (Filtered by User Role)
     */
    public function index(Request $request): void
    {
        $user = Auth::user();
        $role = $user['role'] ?? 'STAF';
        $userUnit = $user['unit'] ?? 'PENTADBIRAN';

        $pendingUnitTickets = [];
        $pendingICTTickets = [];
        $activeLoans = [];

        if ($role === 'KETUA_UNIT' || $role === 'ADMIN') {
            $pendingUnitTickets = $this->ticketRepo->getPendingUnitApprovals($userUnit);
            if ($role === 'ADMIN') {
                // Admin can see all pending unit approvals across all 6 units
                $pendingUnitTickets = $this->ticketRepo->query()
                    ->where('status', 'MENUNGGU_SOKONGAN_UNIT')
                    ->orderBy('created_at', 'ASC')
                    ->get();
            }
        }

        if ($role === 'ADMIN') {
            $pendingICTTickets = $this->ticketRepo->getPendingICTApprovals();
            $activeLoans = $this->ticketRepo->getActiveLoans();
        }

        $this->render('approvals/index', [
            'pageTitle' => 'Pusat Kelulusan & Pengesahan - ' . app_config('app.short_name'),
            'pendingUnit' => TicketViewModel::presentCollection($pendingUnitTickets),
            'pendingICT' => TicketViewModel::presentCollection($pendingICTTickets),
            'activeLoans' => TicketViewModel::presentCollection($activeLoans),
        ]);
    }

    /**
     * Unit Approval Action
     */
    public function approveUnit(Request $request, string $id): void
    {
        $user = Auth::user();
        $notes = (string) $request->input('notes', 'Permohonan disokong dan diperakukan.');

        $success = $this->approvalService->reviewByUnit($id, true, $notes, $user);

        if ($success) {
            $this->redirect("/tickets/{$id}", 'success', 'Permohonan telah disokong dan dihantar ke Unit ICT BKP untuk kelulusan.');
        } else {
            $this->redirect("/tickets/{$id}", 'error', 'Gagal memproses sokongan permohonan.');
        }
    }

    /**
     * Unit Rejection Action
     */
    public function rejectUnit(Request $request, string $id): void
    {
        $user = Auth::user();
        $notes = (string) $request->input('notes', 'Tidak disokong.');

        if (empty(trim($notes))) {
            $this->redirect("/tickets/{$id}", 'error', 'Sila nyatakan ulasan/sebab penolakan permohonan.');
        }

        $success = $this->approvalService->reviewByUnit($id, false, $notes, $user);

        if ($success) {
            $this->redirect("/tickets/{$id}", 'info', 'Permohonan telah ditolak di peringkat unit.');
        } else {
            $this->redirect("/tickets/{$id}", 'error', 'Gagal memproses penolakan.');
        }
    }

    /**
     * ICT Approval Action (Assign assets / technician)
     */
    public function approveICT(Request $request, string $id): void
    {
        $user = Auth::user();
        $notes = (string) $request->input('notes', 'Permohonan diluluskan oleh Unit ICT BKP.');
        $assignedAssetIds = (array) $request->input('assigned_asset_ids', []);
        $technicianId = (string) $request->input('assigned_technician_id', '');

        $technicianName = null;
        if (!empty($technicianId)) {
            $tech = $this->userRepo->find($technicianId);
            $technicianName = $tech['name'] ?? null;
        }

        $success = $this->approvalService->reviewByICT(
            $id,
            true,
            $notes,
            $user,
            $assignedAssetIds,
            $technicianId ?: null,
            $technicianName
        );

        if ($success) {
            $this->redirect("/tickets/{$id}", 'success', 'Permohonan telah berjaya diluluskan rasmi oleh ICT BKP.');
        } else {
            $this->redirect("/tickets/{$id}", 'error', 'Gagal meluluskan permohonan.');
        }
    }

    /**
     * ICT Rejection Action
     */
    public function rejectICT(Request $request, string $id): void
    {
        $user = Auth::user();
        $notes = (string) $request->input('notes', 'Permohonan tidak dapat dipertimbangkan.');

        if (empty(trim($notes))) {
            $this->redirect("/tickets/{$id}", 'error', 'Sila nyatakan ulasan/sebab penolakan.');
        }

        $success = $this->approvalService->reviewByICT($id, false, $notes, $user);

        if ($success) {
            $this->redirect("/tickets/{$id}", 'info', 'Permohonan telah ditolak oleh Unit ICT BKP.');
        } else {
            $this->redirect("/tickets/{$id}", 'error', 'Gagal menolak permohonan.');
        }
    }

    /**
     * Mark Equipment Handed Over
     */
    public function handover(Request $request, string $id): void
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->abort(404);
        }

        $assetIds = $ticket['assigned_asset_ids'] ?? [];
        $notes = (string) $request->input('handover_notes', 'Aset diserahkan dalam keadaan baik.');

        $this->assetService->markHandedOver($id, $assetIds, $notes);
        $this->redirect("/tickets/{$id}", 'success', 'Aset telah berjaya diserahkan kepada pemohon.');
    }

    /**
     * Mark Equipment Returned
     */
    public function returnAsset(Request $request, string $id): void
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->abort(404);
        }

        $assetIds = $ticket['assigned_asset_ids'] ?? [];
        $condition = (string) $request->input('condition', 'BAIK');
        $notes = (string) $request->input('return_notes', 'Pemulangan aset disahkan.');

        $this->assetService->markReturned($id, $assetIds, $condition, $notes);
        $this->redirect("/tickets/{$id}", 'success', 'Pemulangan peralatan telah disahkan dan rekod ditutup.');
    }
}
