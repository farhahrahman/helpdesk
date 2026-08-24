<?php
declare(strict_types=1);

namespace App\ViewModels;

use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;

/**
 * Enterprise Dashboard ViewModel
 * Aggregates statistics, KPIs, and calendar schedules
 */
class DashboardViewModel
{
    private TicketRepository $ticketRepo;
    private AssetRepository $assetRepo;
    private UserRepository $userRepo;

    public function __construct(
        ?TicketRepository $ticketRepo = null,
        ?AssetRepository $assetRepo = null,
        ?UserRepository $userRepo = null
    ) {
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    public function build(array $user): array
    {
        $role = $user['role'] ?? 'STAF';
        $userUnit = $user['unit'] ?? 'PENTADBIRAN';

        $allTickets = $this->ticketRepo->all();
        $allAssets = $this->assetRepo->all();

        // Scope tickets by role
        $scopedTickets = $allTickets;
        if ($role === 'STAF') {
            $scopedTickets = array_filter($allTickets, fn($t) => ($t['user_id'] ?? '') === $user['id']);
        } elseif ($role === 'KETUA_UNIT') {
            $scopedTickets = array_filter($allTickets, fn($t) => ($t['unit'] ?? '') === $userUnit);
        }

        // Metrics
        $totalTickets = count($scopedTickets);
        $pendingUnit = 0;
        $pendingICT = 0;
        $activeApproved = 0;
        $completed = 0;

        foreach ($scopedTickets as $t) {
            $st = $t['status'] ?? '';
            if ($st === 'MENUNGGU_SOKONGAN_UNIT') $pendingUnit++;
            elseif ($st === 'MENUNGGU_KELULUSAN_ICT') $pendingICT++;
            elseif (in_array($st, ['DILULUSKAN', 'SEDANG_BERLANGSUNG'])) $activeApproved++;
            elseif ($st === 'SELESAI') $completed++;
        }

        // Asset statistics
        $totalAssets = count($allAssets);
        $availableAssets = 0;
        $borrowedAssets = 0;

        foreach ($allAssets as $a) {
            if (($a['status'] ?? '') === 'TERSEDIA') $availableAssets++;
            elseif (($a['status'] ?? '') === 'DIPINJAM') $borrowedAssets++;
        }

        // Category breakdown
        $catCounts = [
            'PEMINJAMAN_ASET' => 0,
            'SOKONGAN_MESYUARAT' => 0,
            'MEDIA_JURUKAMERA' => 0,
        ];
        foreach ($allTickets as $t) {
            $c = $t['category'] ?? 'PEMINJAMAN_ASET';
            if (isset($catCounts[$c])) {
                $catCounts[$c]++;
            }
        }

        // Unit breakdown
        $unitCounts = [];
        $unitsConfig = app_config('units', []);
        foreach ($unitsConfig as $code => $u) {
            $unitCounts[$code] = [
                'code' => $code,
                'name' => $u['short_name'],
                'color' => $u['badge_color'],
                'count' => 0,
            ];
        }
        foreach ($allTickets as $t) {
            $u = $t['unit'] ?? 'PENTADBIRAN';
            if (isset($unitCounts[$u])) {
                $unitCounts[$u]['count']++;
            }
        }

        // Recent items
        $recentTickets = array_slice($scopedTickets, 0, 5);
        $recentPresented = TicketViewModel::presentCollection($recentTickets);

        // Upcoming schedule for calendar/timeline
        $upcomingLoans = array_filter($allTickets, function ($t) {
            return in_array($t['status'] ?? '', ['DILULUSKAN', 'SEDANG_BERLANGSUNG', 'MENUNGGU_KELULUSAN_ICT']);
        });
        usort($upcomingLoans, fn($a, $b) => strcmp($a['start_date'] ?? '', $b['start_date'] ?? ''));
        $upcomingPresented = TicketViewModel::presentCollection(array_slice($upcomingLoans, 0, 7));

        return [
            'metrics' => [
                'total' => $totalTickets,
                'pending_unit' => $pendingUnit,
                'pending_ict' => $pendingICT,
                'active_approved' => $activeApproved,
                'completed' => $completed,
                'total_assets' => $totalAssets,
                'available_assets' => $availableAssets,
                'borrowed_assets' => $borrowedAssets,
            ],
            'category_counts' => $catCounts,
            'unit_counts' => $unitCounts,
            'recent_tickets' => $recentPresented,
            'upcoming_loans' => $upcomingPresented,
        ];
    }
}
