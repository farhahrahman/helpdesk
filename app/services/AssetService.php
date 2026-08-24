<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;

/**
 * ICT Asset & Equipment Management Service
 */
class AssetService
{
    private AssetRepository $assetRepo;
    private TicketRepository $ticketRepo;
    private AuditService $audit;

    public function __construct(
        ?AssetRepository $assetRepo = null,
        ?TicketRepository $ticketRepo = null,
        ?AuditService $audit = null
    ) {
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->audit = $audit ?? new AuditService();
    }

    public function getAllAssets(): array
    {
        return $this->assetRepo->all();
    }

    public function getAsset(string $id): ?array
    {
        return $this->assetRepo->find($id);
    }

    public function getAvailableAssets(?string $type = null): array
    {
        return $this->assetRepo->getAvailableAssets($type);
    }

    /**
     * Check if specific assets are available between dates
     */
    public function checkAvailability(array $assetIds, string $startDate, string $endDate, ?string $excludeTicketId = null): array
    {
        $conflicts = [];
        $activeTickets = $this->ticketRepo->getActiveLoans();

        $reqStart = strtotime($startDate);
        $reqEnd = strtotime($endDate);

        foreach ($activeTickets as $ticket) {
            if ($excludeTicketId && ($ticket['id'] ?? '') === $excludeTicketId) {
                continue;
            }

            $ticketStart = strtotime($ticket['start_date'] ?? '');
            $ticketEnd = strtotime($ticket['end_date'] ?? '');

            // Check date overlap: (StartA <= EndB) and (EndA >= StartB)
            if ($ticketStart && $ticketEnd && $reqStart <= $ticketEnd && $reqEnd >= $ticketStart) {
                $assignedAssets = $ticket['assigned_asset_ids'] ?? [];
                $intersect = array_intersect($assetIds, $assignedAssets);
                if (!empty($intersect)) {
                    foreach ($intersect as $assetId) {
                        $asset = $this->assetRepo->find($assetId);
                        $conflicts[] = [
                            'asset_id' => $assetId,
                            'asset_name' => $asset['name'] ?? $assetId,
                            'conflicting_ticket_ref' => $ticket['reference_no'] ?? '',
                            'conflicting_dates' => "{$ticket['start_date']} hingga {$ticket['end_date']}",
                        ];
                    }
                }
            }
        }

        return $conflicts;
    }

    /**
     * Create new asset
     */
    public function createAsset(array $data): array
    {
        $record = [
            'name' => trim($data['name']),
            'asset_code' => strtoupper(trim($data['asset_code'])),
            'type' => $data['type'],
            'brand' => trim($data['brand'] ?? ''),
            'model' => trim($data['model'] ?? ''),
            'serial_no' => trim($data['serial_no'] ?? ''),
            'status' => $data['status'] ?? 'TERSEDIA', // TERSEDIA, DIPINJAM, PENYELENGGARAAN, ROSAK
            'condition' => $data['condition'] ?? 'BAIK',
            'notes' => trim($data['notes'] ?? ''),
            'accessories' => $data['accessories'] ?? [],
        ];

        $created = $this->assetRepo->create($record);
        $this->audit->log('ASSET_CREATED', "Aset baru didaftarkan: {$created['name']} ({$created['asset_code']})");

        return $created;
    }

    /**
     * Update asset
     */
    public function updateAsset(string $id, array $data): ?array
    {
        $existing = $this->assetRepo->find($id);
        if (!$existing) {
            return null;
        }

        $updateData = [
            'name' => trim($data['name'] ?? $existing['name']),
            'asset_code' => strtoupper(trim($data['asset_code'] ?? $existing['asset_code'])),
            'type' => $data['type'] ?? $existing['type'],
            'brand' => trim($data['brand'] ?? $existing['brand'] ?? ''),
            'model' => trim($data['model'] ?? $existing['model'] ?? ''),
            'serial_no' => trim($data['serial_no'] ?? $existing['serial_no'] ?? ''),
            'status' => $data['status'] ?? $existing['status'],
            'condition' => $data['condition'] ?? $existing['condition'],
            'notes' => trim($data['notes'] ?? $existing['notes'] ?? ''),
        ];

        $updated = $this->assetRepo->update($id, $updateData);
        $this->audit->log('ASSET_UPDATED', "Aset dikemaskini: {$updated['name']} ({$updated['asset_code']})");

        return $updated;
    }

    /**
     * Handover asset to applicant
     */
    public function markHandedOver(string $ticketId, array $assetIds, string $handoverNotes = ''): bool
    {
        foreach ($assetIds as $assetId) {
            $this->assetRepo->updateStatus($assetId, 'DIPINJAM', $ticketId);
        }

        $this->ticketRepo->update($ticketId, [
            'status' => 'SEDANG_BERLANGSUNG',
            'handover_at' => date('c'),
            'handover_notes' => $handoverNotes,
        ]);

        $this->audit->log('ASSET_HANDOVER', "Peralatan telah diserahkan kepada pemohon bagi tiket ID {$ticketId}", $ticketId);
        return true;
    }

    /**
     * Return asset to inventory
     */
    public function markReturned(string $ticketId, array $assetIds, string $condition = 'BAIK', string $returnNotes = ''): bool
    {
        foreach ($assetIds as $assetId) {
            $this->assetRepo->update($assetId, [
                'status' => 'TERSEDIA',
                'condition' => $condition,
                'current_ticket_id' => null,
            ]);
        }

        $this->ticketRepo->update($ticketId, [
            'status' => 'SELESAI',
            'returned_at' => date('c'),
            'return_condition' => $condition,
            'return_notes' => $returnNotes,
        ]);

        $this->audit->log('ASSET_RETURNED', "Peralatan telah dipulangkan dan ditutup bagi tiket ID {$ticketId}", $ticketId);
        return true;
    }
}
