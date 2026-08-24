<?php
declare(strict_types=1);

namespace App\ViewModels;

use App\Core\Auth;

/**
 * Enterprise Ticket ViewModel
 * Transforms raw ticket data into enriched visual-ready presentation models
 */
class TicketViewModel
{
    public static function present(array $ticket): array
    {
        $statuses = app_config('roles.statuses', []);
        $categories = app_config('services.categories', []);
        $units = app_config('units', []);
        $equipmentTypes = app_config('services.equipment_types', []);

        $statusKey = $ticket['status'] ?? 'MENUNGGU_SOKONGAN_UNIT';
        $statusConfig = $statuses[$statusKey] ?? [
            'label' => $statusKey,
            'badge_class' => 'bg-slate-100 text-slate-700 border-slate-200',
            'icon' => 'help-circle',
        ];

        $catKey = $ticket['category'] ?? 'PEMINJAMAN_ASET';
        $catConfig = $categories[$catKey] ?? [
            'name' => $catKey,
            'icon' => 'tag',
            'badge' => 'slate',
        ];

        $unitKey = $ticket['unit'] ?? 'PENTADBIRAN';
        $unitConfig = $units[$unitKey] ?? [
            'name' => $unitKey,
            'short_name' => $unitKey,
            'badge_color' => 'slate',
        ];

        // Format equipment type names
        $requestedEquipments = [];
        foreach ($ticket['requested_equipment_types'] ?? [] as $eqType) {
            $requestedEquipments[] = $equipmentTypes[$eqType]['name'] ?? $eqType;
        }

        $currentUser = Auth::user();
        $canApproveUnit = false;
        $canApproveICT = false;
        $canHandover = false;
        $canReturn = false;
        $canCancel = false;

        if ($currentUser) {
            $role = $currentUser['role'] ?? 'STAF';
            $userUnit = $currentUser['unit'] ?? '';

            if ($statusKey === 'MENUNGGU_SOKONGAN_UNIT') {
                if ($role === 'ADMIN' || ($role === 'KETUA_UNIT' && $userUnit === $unitKey)) {
                    $canApproveUnit = true;
                }
            }

            if ($statusKey === 'MENUNGGU_KELULUSAN_ICT') {
                if ($role === 'ADMIN') {
                    $canApproveICT = true;
                }
            }

            if ($statusKey === 'DILULUSKAN' && $role === 'ADMIN') {
                $canHandover = true;
            }

            if ($statusKey === 'SEDANG_BERLANGSUNG' && $role === 'ADMIN') {
                $canReturn = true;
            }

            if (!in_array($statusKey, ['SELESAI', 'DIBATALKAN', 'DITOLAK'])) {
                if ($ticket['user_id'] === $currentUser['id'] || $role === 'ADMIN') {
                    $canCancel = true;
                }
            }
        }

        return array_merge($ticket, [
            'status_label' => $statusConfig['label'],
            'status_badge_class' => $statusConfig['badge_class'],
            'status_icon' => $statusConfig['icon'],
            'category_name' => $catConfig['name'],
            'category_icon' => $catConfig['icon'],
            'unit_short_name' => $unitConfig['short_name'] ?? $unitKey,
            'unit_badge_color' => $unitConfig['badge_color'] ?? 'slate',
            'equipment_names' => $requestedEquipments,
            'formatted_start_date' => format_date($ticket['start_date'] ?? ''),
            'formatted_end_date' => format_date($ticket['end_date'] ?? ''),
            'formatted_created_at' => format_datetime($ticket['created_at'] ?? ''),
            'can_approve_unit' => $canApproveUnit,
            'can_approve_ict' => $canApproveICT,
            'can_handover' => $canHandover,
            'can_return' => $canReturn,
            'can_cancel' => $canCancel,
        ]);
    }

    public static function presentCollection(array $tickets): array
    {
        return array_map([self::class, 'present'], $tickets);
    }
}
