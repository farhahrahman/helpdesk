<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Repositories\PositionRepository;
use App\Repositories\UnitRepository;
use App\Services\AuditService;

/**
 * Master Data Controller: Unit & Jawatan BKP (Admin Only)
 */
class UnitController extends BaseController
{
    private UnitRepository $unitRepo;
    private PositionRepository $posRepo;
    private AuditService $auditService;

    public function __construct(
        ?UnitRepository $unitRepo = null,
        ?PositionRepository $posRepo = null,
        ?AuditService $auditService = null
    ) {
        $this->unitRepo = $unitRepo ?? new UnitRepository();
        $this->posRepo = $posRepo ?? new PositionRepository();
        $this->auditService = $auditService ?? new AuditService();
    }

    /**
     * Master Data Screen: Unit & Jawatan
     */
    public function index(Request $request): void
    {
        $units = $this->unitRepo->all();
        $positions = $this->posRepo->all();

        $this->render('units/index', [
            'pageTitle' => 'Senarai Jawatan & Unit - ' . app_config('app.short_name'),
            'units' => $units,
            'positions' => $positions,
        ]);
    }

    /**
     * Update Unit / Bahagian Name & Details
     */
    public function updateUnit(Request $request, string $code): void
    {
        $data = $request->all();
        $name = trim((string)($data['name'] ?? ''));
        $shortName = trim((string)($data['short_name'] ?? ''));
        $description = trim((string)($data['description'] ?? ''));
        $badgeColor = trim((string)($data['badge_color'] ?? 'blue'));

        if (empty($name)) {
            $this->redirect('/units', 'error', 'Sila masukkan nama penuh unit/bahagian.');
        }

        $updated = $this->unitRepo->updateUnit($code, [
            'name' => $name,
            'short_name' => $shortName ?: $name,
            'description' => $description,
            'badge_color' => $badgeColor,
        ]);

        if ($updated) {
            $this->auditService->log(
                'UNIT_UPDATED',
                "Nama/maklumat unit {$code} telah dikemaskini kepada '{$name}'"
            );
            $this->redirect('/units', 'success', "Maklumat unit {$code} ({$name}) telah berjaya dikemaskini.");
        } else {
            $this->redirect('/units', 'error', "Gagal mengemaskini maklumat unit {$code}.");
        }
    }

    /**
     * Create New Unit
     */
    public function createUnit(Request $request): void
    {
        $data = $request->all();
        $code = strtoupper(trim((string)($data['code'] ?? '')));
        $name = trim((string)($data['name'] ?? ''));
        $shortName = trim((string)($data['short_name'] ?? ''));
        $description = trim((string)($data['description'] ?? ''));
        $badgeColor = trim((string)($data['badge_color'] ?? 'blue'));

        if (empty($code) || empty($name)) {
            $this->redirect('/units', 'error', 'Sila lengkapkan kod unit dan nama penuh unit.');
        }

        $existing = $this->unitRepo->findByCode($code);
        if ($existing) {
            $this->redirect('/units', 'error', "Kod unit '{$code}' telah didaftarkan sebelum ini.");
        }

        $this->unitRepo->create([
            'id' => $code,
            'code' => $code,
            'name' => $name,
            'short_name' => $shortName ?: $name,
            'description' => $description,
            'badge_color' => $badgeColor,
        ]);

        $this->auditService->log('UNIT_CREATED', "Unit baru didaftarkan: {$name} ({$code})");
        $this->redirect('/units', 'success', "Unit baru {$name} ({$code}) telah berjaya didaftarkan.");
    }

    /**
     * Add New Designation / Jawatan
     */
    public function addPosition(Request $request): void
    {
        $title = trim((string)$request->input('title', ''));

        if (empty($title)) {
            $this->redirect('/units', 'error', 'Sila masukkan gelaran jawatan / gred.');
        }

        $this->posRepo->addPosition($title);
        $this->auditService->log('POSITION_CREATED', "Gelaran jawatan baru ditambah: {$title}");

        $this->redirect('/units', 'success', "Gelaran jawatan '{$title}' telah berjaya ditambah.");
    }

    /**
     * Update Existing Designation / Jawatan
     */
    public function updatePosition(Request $request, string $id): void
    {
        $title = trim((string)$request->input('title', ''));

        if (empty($title)) {
            $this->redirect('/units', 'error', 'Sila masukkan gelaran jawatan.');
        }

        $this->posRepo->update($id, ['title' => $title]);
        $this->auditService->log('POSITION_UPDATED', "Gelaran jawatan {$id} dikemaskini kepada '{$title}'");

        $this->redirect('/units', 'success', "Jawatan telah berjaya dikemaskini kepada '{$title}'.");
    }

    /**
     * Delete / Remove Designation
     */
    public function deletePosition(Request $request, string $id): void
    {
        $this->posRepo->delete($id);
        $this->auditService->log('POSITION_DELETED', "Gelaran jawatan {$id} dipadamkan daripada senarai");

        $this->redirect('/units', 'success', 'Gelaran jawatan telah dipadamkan.');
    }
}
