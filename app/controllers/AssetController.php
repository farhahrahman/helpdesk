<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\AssetRepository;
use App\Services\AssetService;
use App\ViewModels\AssetViewModel;

/**
 * Asset Inventory Management Controller
 */
class AssetController extends BaseController
{
    private AssetService $assetService;
    private AssetRepository $assetRepo;

    public function __construct(?AssetService $assetService = null, ?AssetRepository $assetRepo = null)
    {
        $this->assetService = $assetService ?? new AssetService();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
    }

    /**
     * Asset Listing
     */
    public function index(Request $request): void
    {
        $typeFilter = (string) $request->input('type', '');
        $statusFilter = (string) $request->input('status', '');

        $all = $this->assetRepo->all();

        if (!empty($typeFilter)) {
            $all = array_filter($all, fn($a) => ($a['type'] ?? '') === $typeFilter);
        }
        if (!empty($statusFilter)) {
            $all = array_filter($all, fn($a) => ($a['status'] ?? '') === $statusFilter);
        }

        $presented = AssetViewModel::presentCollection(array_values($all));

        $this->render('assets/index', [
            'pageTitle' => 'Pengurusan Inventori Aset ICT - ' . app_config('app.short_name'),
            'assets' => $presented,
            'equipmentTypes' => app_config('services.equipment_types', []),
            'typeFilter' => $typeFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Show New Asset Form
     */
    public function create(Request $request): void
    {
        $this->render('assets/form', [
            'pageTitle' => 'Daftar Aset ICT Baru - ' . app_config('app.short_name'),
            'asset' => null,
            'equipmentTypes' => app_config('services.equipment_types', []),
        ]);
    }

    /**
     * Store New Asset
     */
    public function store(Request $request): void
    {
        $data = $request->all();

        if (empty($data['name']) || empty($data['asset_code']) || empty($data['type'])) {
            Session::flashInput($data);
            $this->redirect('/assets/create', 'error', 'Sila lengkapkan nama aset, no. kod pendaftaran dan jenis peralatan.');
        }

        $existing = $this->assetRepo->findByAssetCode($data['asset_code']);
        if ($existing) {
            Session::flashInput($data);
            $this->redirect('/assets/create', 'error', "Kod aset '{$data['asset_code']}' telah didaftarkan sebelumnya.");
        }

        $this->assetService->createAsset($data);
        $this->redirect('/assets', 'success', 'Aset baru telah berjaya didaftarkan.');
    }

    /**
     * Show Edit Asset Form
     */
    public function edit(Request $request, string $id): void
    {
        $asset = $this->assetRepo->find($id);
        if (!$asset) {
            $this->abort(404, 'Aset tidak dijumpai.');
        }

        $this->render('assets/form', [
            'pageTitle' => "Kemaskini Aset {$asset['asset_code']} - " . app_config('app.short_name'),
            'asset' => $asset,
            'equipmentTypes' => app_config('services.equipment_types', []),
        ]);
    }

    /**
     * Update Asset
     */
    public function update(Request $request, string $id): void
    {
        $data = $request->all();
        $updated = $this->assetService->updateAsset($id, $data);

        if ($updated) {
            $this->redirect('/assets', 'success', 'Maklumat aset telah dikemaskini.');
        } else {
            $this->redirect("/assets/{$id}/edit", 'error', 'Gagal mengemaskini aset.');
        }
    }

    /**
     * Delete Asset
     */
    public function delete(Request $request, string $id): void
    {
        $this->assetRepo->delete($id);
        $this->redirect('/assets', 'success', 'Aset telah dipadamkan daripada rekod.');
    }
}
