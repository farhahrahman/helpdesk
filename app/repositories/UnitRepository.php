<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Storage\JsonStorageEngine;

/**
 * Repository for Master Data: Unit / Bahagian BKP
 */
class UnitRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('units');
        $this->ensureSeeded();
    }

    /**
     * Ensure initial units exist in storage
     */
    private function ensureSeeded(): void
    {
        $data = $this->engine->read('units');
        if (empty($data)) {
            $defaultUnits = require dirname(__DIR__) . '/config/units.php';
            $seeded = [];
            foreach ($defaultUnits as $code => $u) {
                $seeded[] = [
                    'id' => $code,
                    'code' => $code,
                    'name' => $u['name'],
                    'short_name' => $u['short_name'],
                    'badge_color' => $u['badge_color'] ?? 'slate',
                    'description' => $u['description'] ?? '',
                    'created_at' => date('c'),
                    'updated_at' => date('c'),
                ];
            }
            $this->engine->write('units', $seeded);
        }
    }

    /**
     * Get all units keyed by unit code
     */
    public function getAllKeyed(): array
    {
        $all = $this->all();
        $keyed = [];
        foreach ($all as $u) {
            $code = $u['code'] ?? $u['id'];
            $keyed[$code] = $u;
        }
        return $keyed;
    }

    public function findByCode(string $code): ?array
    {
        return $this->query()->where('code', strtoupper(trim($code)))->first();
    }

    public function updateUnit(string $code, array $data): ?array
    {
        $unit = $this->findByCode($code);
        if (!$unit) {
            return null;
        }

        $updateData = [
            'name' => trim($data['name'] ?? $unit['name']),
            'short_name' => trim($data['short_name'] ?? $unit['short_name']),
            'badge_color' => trim($data['badge_color'] ?? $unit['badge_color'] ?? 'blue'),
            'description' => trim($data['description'] ?? $unit['description'] ?? ''),
        ];

        return $this->update($unit['id'], $updateData);
    }
}
