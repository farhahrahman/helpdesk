<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\ViewModels\DashboardViewModel;
use App\ViewModels\TicketViewModel;
use App\Repositories\TicketRepository;

/**
 * Dashboard Controller
 */
class DashboardController extends BaseController
{
    private DashboardViewModel $dashboardVm;
    private TicketRepository $ticketRepo;

    public function __construct(
        ?DashboardViewModel $dashboardVm = null,
        ?TicketRepository $ticketRepo = null
    ) {
        $this->dashboardVm = $dashboardVm ?? new DashboardViewModel();
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
    }

    /**
     * Executive and Staff Dashboard View
     */
    public function index(Request $request): void
    {
        $user = Auth::user();
        $data = $this->dashboardVm->build($user);
        $data['pageTitle'] = 'Papan Pemuka Eksekutif - ' . app_config('app.short_name');

        $this->render('dashboard/index', $data);
    }

    /**
     * Interactive Calendar & Resource Timeline
     */
    public function calendar(Request $request): void
    {
        $allTickets = $this->ticketRepo->all();
        // Filter out rejected or cancelled
        $activeEvents = array_filter($allTickets, function ($t) {
            return !in_array($t['status'] ?? '', ['DITOLAK', 'DIBATALKAN']);
        });

        $presented = TicketViewModel::presentCollection($activeEvents);

        $this->render('dashboard/calendar', [
            'pageTitle' => 'Jadual Tempahan & Kalendar Aktiviti - ' . app_config('app.short_name'),
            'events' => $presented,
        ]);
    }
}
