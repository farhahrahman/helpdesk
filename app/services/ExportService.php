<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\TicketRepository;

/**
 * Report & Data Export Service
 */
class ExportService
{
    private TicketRepository $ticketRepo;

    public function __construct(?TicketRepository $ticketRepo = null)
    {
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
    }

    /**
     * Generate CSV export of tickets
     */
    public function exportTicketsCsv(array $filters = []): void
    {
        $tickets = $this->ticketRepo->getFilteredTickets($filters, 1, 5000)['data'] ?? [];

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="laporan_helpdesk_ictbkp_' . date('Ymd_His') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // Add UTF-8 BOM for Microsoft Excel compatibility
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header row
        fputcsv($out, [
            'No. Rujukan',
            'Kategori',
            'Tajuk Permohonan',
            'Tujuan',
            'Nama Pemohon',
            'Jawatan',
            'Unit / Bahagian',
            'Status Semasa',
            'Tarikh Mula',
            'Tarikh Tamat',
            'Lokasi',
            'Sokongan Unit',
            'Kelulusan ICT',
            'Tarikh Dicipta',
        ]);

        $statuses = app_config('roles.statuses', []);
        $categories = app_config('services.categories', []);

        foreach ($tickets as $t) {
            $catName = $categories[$t['category']]['name'] ?? $t['category'];
            $statusLabel = $statuses[$t['status']]['label'] ?? $t['status'];
            $unitApproval = $t['unit_approval']['status'] ?? 'PENDING';
            $ictApproval = $t['ict_approval']['status'] ?? 'PENDING';

            fputcsv($out, [
                $t['reference_no'] ?? '',
                $catName,
                $t['title'] ?? '',
                $t['purpose'] ?? '',
                $t['applicant_name'] ?? '',
                $t['applicant_position'] ?? '',
                $t['unit_name'] ?? $t['unit'] ?? '',
                $statusLabel,
                $t['start_date'] ?? '',
                $t['end_date'] ?? '',
                $t['location'] ?? '',
                $unitApproval,
                $ictApproval,
                $t['created_at'] ?? '',
            ]);
        }

        fclose($out);
        exit;
    }
}
