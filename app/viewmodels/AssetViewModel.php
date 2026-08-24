<?php
declare(strict_types=1);

namespace App\ViewModels;

/**
 * Enterprise Asset ViewModel
 */
class AssetViewModel
{
    public static function present(array $asset): array
    {
        $statusClasses = [
            'TERSEDIA' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-500/20',
            'DIPINJAM' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-500/20',
            'PENYELENGGARAAN' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-500/20',
            'ROSAK' => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-500/20',
        ];

        $conditionClasses = [
            'BAIK' => 'bg-slate-100 text-slate-700',
            'SEDERHANA' => 'bg-amber-100 text-amber-800',
            'PERLU_SERVIS' => 'bg-rose-100 text-rose-800',
        ];

        $typeIcons = [
            'IPHONE' => 'smartphone',
            'KAMERA_DSLR' => 'camera',
            'MIKROFON_AUDIO' => 'mic',
            'KOMPUTER_RIBA' => 'laptop',
            'PROJEKTOR_SKRIN' => 'monitor',
            'PENUNJUK_LASER' => 'mouse-pointer',
        ];

        $eqTypes = app_config('services.equipment_types', []);
        $typeConfig = $eqTypes[$asset['type'] ?? ''] ?? ['name' => $asset['type'] ?? 'Aset'];

        return array_merge($asset, [
            'type_name' => $typeConfig['name'] ?? $asset['type'],
            'type_icon' => $typeIcons[$asset['type'] ?? ''] ?? 'box',
            'status_badge_class' => $statusClasses[$asset['status'] ?? 'TERSEDIA'] ?? 'bg-slate-100 text-slate-700',
            'condition_badge_class' => $conditionClasses[$asset['condition'] ?? 'BAIK'] ?? 'bg-slate-100 text-slate-700',
        ]);
    }

    public static function presentCollection(array $assets): array
    {
        return array_map([self::class, 'present'], $assets);
    }
}
