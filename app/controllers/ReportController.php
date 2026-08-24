<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Repositories\TicketRepository;
use App\Services\ExportService;
use App\ViewModels\TicketViewModel;

/**
 * Report & Analytics Controller
 */
class ReportController extends BaseController
{
    private TicketRepository $ticketRepo;
    private ExportService $exportService;

    public function __construct(?TicketRepository $ticketRepo = null, ?ExportService $exportService = null)
    {
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->exportService = $exportService ?? new ExportService();
    }

    /**
     * Reports Overview
     */
    public function index(Request $request): void
    {
        $filters = [
            'unit' => (string) $request->input('unit', ''),
            'category' => (string) $request->input('category', ''),
            'status' => (string) $request->input('status', ''),
        ];

        $tickets = $this->ticketRepo->getFilteredTickets($filters, 1, 1000)['data'] ?? [];
        $presented = TicketViewModel::presentCollection($tickets);

        // Calculate unit breakdown
        $unitsConfig = app_config('units', []);
        $statsByUnit = [];
        foreach ($unitsConfig as $code => $u) {
            $statsByUnit[$code] = [
                'name' => $u['name'],
                'short_name' => $u['short_name'],
                'count' => 0,
            ];
        }
        foreach ($tickets as $t) {
            $u = $t['unit'] ?? '';
            if (isset($statsByUnit[$u])) {
                $statsByUnit[$u]['count']++;
            }
        }

        $this->render('reports/index', [
            'pageTitle' => 'Laporan & Statistik Eksekutif - ' . app_config('app.short_name'),
            'tickets' => $presented,
            'statsByUnit' => $statsByUnit,
            'filters' => $filters,
            'units' => $unitsConfig,
            'categories' => app_config('services.categories', []),
            'statuses' => app_config('roles.statuses', []),
        ]);
    }

    /**
     * Export to CSV
     */
    public function export(Request $request): void
    {
        $filters = [
            'unit' => (string) $request->input('unit', ''),
            'category' => (string) $request->input('category', ''),
            'status' => (string) $request->input('status', ''),
        ];

        $this->exportService->exportTicketsCsv($filters);
    }
}
