<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;

/**
 * Approval & Workflow Service
 */
class ApprovalService
{
    private TicketRepository $ticketRepo;
    private AssetRepository $assetRepo;
    private AuditService $audit;

    public function __construct(
        ?TicketRepository $ticketRepo = null,
        ?AssetRepository $assetRepo = null,
        ?AuditService $audit = null
    ) {
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->audit = $audit ?? new AuditService();
    }

    /**
     * Process Unit Level Review (Ketua Unit / Penyelia)
     */
    public function reviewByUnit(string $ticketId, bool $isApproved, string $notes, array $approver): bool
    {
        $ticket = $this->ticketRepo->find($ticketId);
        if (!$ticket) {
            return false;
        }

        $newStatus = $isApproved ? 'MENUNGGU_KELULUSAN_ICT' : 'DITOLAK';
        $approvalState = $isApproved ? 'APPROVED' : 'REJECTED';

        $unitApproval = [
            'status' => $approvalState,
            'approved_by' => $approver['id'],
            'approver_name' => $approver['name'],
            'notes' => trim($notes),
            'action_at' => date('c'),
        ];

        $this->ticketRepo->update($ticketId, [
            'status' => $newStatus,
            'unit_approval' => $unitApproval,
        ]);

        $actionDesc = $isApproved ? 'disokong / diperakukan' : 'tidak disokong';
        $this->audit->log(
            'UNIT_APPROVAL_' . $approvalState,
            "Permohonan {$ticket['reference_no']} {$actionDesc} oleh Ketua Unit {$approver['name']}. Catatan: {$notes}",
            $ticketId
        );

        return true;
    }

    /**
     * Process ICT Level Review (Pegawai ICT BKP / Admin)
     */
    public function reviewByICT(
        string $ticketId,
        bool $isApproved,
        string $notes,
        array $approver,
        array $assignedAssetIds = [],
        ?string $assignedTechnicianId = null,
        ?string $assignedTechnicianName = null
    ): bool {
        $ticket = $this->ticketRepo->find($ticketId);
        if (!$ticket) {
            return false;
        }

        $newStatus = $isApproved ? 'DILULUSKAN' : 'DITOLAK';
        $approvalState = $isApproved ? 'APPROVED' : 'REJECTED';

        $ictApproval = [
            'status' => $approvalState,
            'approved_by' => $approver['id'],
            'approver_name' => $approver['name'],
            'assigned_technician_id' => $assignedTechnicianId,
            'assigned_technician_name' => $assignedTechnicianName,
            'notes' => trim($notes),
            'action_at' => date('c'),
        ];

        $updateData = [
            'status' => $newStatus,
            'ict_approval' => $ictApproval,
            'assigned_asset_ids' => $assignedAssetIds,
        ];

        $this->ticketRepo->update($ticketId, $updateData);

        // If approved and assets assigned, temporarily mark assets in maintenance or ready
        if ($isApproved && !empty($assignedAssetIds)) {
            foreach ($assignedAssetIds as $assetId) {
                // Reserve asset
                $this->assetRepo->update($assetId, ['current_ticket_id' => $ticketId]);
            }
        }

        $actionDesc = $isApproved ? 'diluluskan rasmi' : 'ditolak';
        $this->audit->log(
            'ICT_APPROVAL_' . $approvalState,
            "Permohonan {$ticket['reference_no']} {$actionDesc} oleh Pegawai ICT {$approver['name']}. Catatan: {$notes}",
            $ticketId,
            ['assigned_assets' => $assignedAssetIds, 'technician' => $assignedTechnicianName]
        );

        return true;
    }
}
