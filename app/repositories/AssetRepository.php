<?php
declare(strict_types=1);

namespace App\Repositories;

/**
 * Asset Repository for ICT Inventory Management
 */
class AssetRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('assets');
    }

    public function findByAssetCode(string $assetCode): ?array
    {
        return $this->query()
            ->where('asset_code', strtoupper(trim($assetCode)))
            ->first();
    }

    public function getAvailableAssets(?string $type = null): array
    {
        $q = $this->query()->where('status', 'TERSEDIA');
        if ($type !== null) {
            $q->where('type', $type);
        }
        return $q->orderBy('name', 'ASC')->get();
    }

    public function getByType(string $type): array
    {
        return $this->query()
            ->where('type', $type)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function updateStatus(string $assetId, string $status, ?string $assignedTicketId = null): ?array
    {
        return $this->update($assetId, [
            'status' => $status,
            'current_ticket_id' => $assignedTicketId,
        ]);
    }
}
