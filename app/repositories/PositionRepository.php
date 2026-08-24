<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Storage\JsonStorageEngine;

/**
 * Repository for Master Data: Jawatan & Gred Perkhidmatan
 */
class PositionRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('positions');
        $this->ensureSeeded();
    }

    private function ensureSeeded(): void
    {
        $data = $this->engine->read('positions');
        if (empty($data)) {
            $defaultPosConfig = require dirname(__DIR__) . '/config/positions.php';
            $defaultList = $defaultPosConfig['standard_positions'] ?? [];
            $seeded = [];
            foreach ($defaultList as $index => $posName) {
                $seeded[] = [
                    'id' => 'POS-' . str_pad((string)($index + 1), 3, '0', STR_PAD_LEFT),
                    'title' => $posName,
                    'is_active' => true,
                    'created_at' => date('c'),
                    'updated_at' => date('c'),
                ];
            }
            $this->engine->write('positions', $seeded);
        }
    }

    public function getActiveTitles(): array
    {
        $all = $this->query()->where('is_active', true)->orderBy('title', 'ASC')->get();
        return array_column($all, 'title');
    }

    public function addPosition(string $title): array
    {
        return $this->create([
            'title' => trim($title),
            'is_active' => true,
        ]);
    }
}
