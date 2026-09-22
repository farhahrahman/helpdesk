<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Services\AssetService;
use App\Services\AuditService;
use App\Services\TicketService;
use App\ViewModels\AssetViewModel;
use App\ViewModels\TicketViewModel;

/**
 * Ticket Controller
 */
class TicketController extends BaseController
{
    private TicketService $ticketService;
    private TicketRepository $ticketRepo;
    private AssetService $assetService;
    private AssetRepository $assetRepo;
    private UserRepository $userRepo;
    private AuditService $auditService;

    public function __construct(
        ?TicketService $ticketService = null,
        ?TicketRepository $ticketRepo = null,
        ?AssetService $assetService = null,
        ?AssetRepository $assetRepo = null,
        ?UserRepository $userRepo = null,
        ?AuditService $auditService = null
    ) {
        $this->ticketService = $ticketService ?? new TicketService();
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->assetService = $assetService ?? new AssetService();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->auditService = $auditService ?? new AuditService();
    }

    /**
     * Ticket Listing with Search & Filters (Requires Login to View History)
     */
    public function index(Request $request): void
    {
        $user = Auth::user();
        $role = $user['role'] ?? 'STAF';
        $page = (int) $request->input('page', 1);

        $filters = [
            'search' => (string) $request->input('search', ''),
            'status' => (string) $request->input('status', ''),
            'category' => (string) $request->input('category', ''),
            'unit' => (string) $request->input('unit', ''),
        ];

        // Scope by RBAC
        if ($role === 'STAF') {
            $filters['user_id'] = $user['id'];
        } elseif ($role === 'KETUA_UNIT' && empty($filters['unit'])) {
            $filters['unit'] = $user['unit'];
        }

        $paginated = $this->ticketRepo->getFilteredTickets($filters, $page, 10);
        $paginated['data'] = TicketViewModel::presentCollection($paginated['data']);

        $this->render('tickets/index', [
            'pageTitle' => 'Sejarah Permohonan ICT - ' . app_config('app.short_name'),
            'paginated' => $paginated,
            'filters' => $filters,
            'statuses' => app_config('roles.statuses', []),
            'categories' => app_config('services.categories', []),
            'units' => app_config('units', []),
        ]);
    }

    /**
     * Show New Request Form (Accessible to Public & Logged In Staff)
     */
    public function create(Request $request): void
    {
        $availableAssets = $this->assetRepo->getAvailableAssets();
        $isLoggedIn = Auth::check();
        $layout = $isLoggedIn ? 'app' : 'public';

        $this->render('tickets/create', [
            'pageTitle' => 'Borang Permohonan Perkhidmatan ICT - ' . app_config('app.short_name'),
            'categories' => app_config('services.categories', []),
            'equipmentTypes' => app_config('services.equipment_types', []),
            'meetingTypes' => app_config('services.meeting_support_types', []),
            'meetingPlatforms' => app_config('services.meeting_platforms', []),
            'meetingVenues' => app_config('services.meeting_venues', []),
            'mediaScopes' => app_config('services.media_scopes', []),
            'technicalSupportTypes' => app_config('services.technical_support_types', []),
            'kuartersComplaintTypes' => app_config('services.kuarters_complaint_types', []),
            'kuartersComplexes' => app_config('services.kuarters_complexes', []),
            'units' => app_config('units', []),
            'availableAssets' => AssetViewModel::presentCollection($availableAssets),
        ], $layout);
    }

    /**
     * Store New Request (Boleh Hantar Terus Tanpa Login)
     */
    public function store(Request $request): void
    {
        $data = $request->all();

        // Merge loan specific fields if provided
        if (($data['category'] ?? '') === 'PEMINJAMAN_ASET') {
            if (!empty($data['purpose_loan'])) {
                $data['purpose'] = $data['purpose_loan'];
            }
            if (!empty($data['location_loan'])) {
                $data['location'] = $data['location_loan'];
            }
            if (!empty($data['start_date_loan'])) {
                $data['start_date'] = $data['start_date_loan'];
            }
            if (!empty($data['end_date_loan'])) {
                $data['end_date'] = $data['end_date_loan'];
            }
            if (!empty($data['applicant_phone_loan'])) {
                $data['applicant_phone'] = $data['applicant_phone_loan'];
            }
            if (!empty($data['unit_loan'])) {
                $data['unit'] = $data['unit_loan'];
            }
            if (!empty($data['applicant_name_loan'])) {
                $data['applicant_name'] = $data['applicant_name_loan'];
            }
            if (!empty($data['applicant_email_loan'])) {
                $data['applicant_email'] = $data['applicant_email_loan'];
            }
            if (!empty($data['applicant_position_loan'])) {
                $data['applicant_position'] = $data['applicant_position_loan'];
            }
        }

        // Merge meeting specific fields if provided
        if (($data['category'] ?? '') === 'SOKONGAN_MESYUARAT') {
            if (!empty($data['meeting_title'])) {
                $data['title'] = $data['meeting_title'];
            }
            if (!empty($data['meeting_vip'])) {
                $data['vip_attendees'] = $data['meeting_vip'];
            }
            if (!empty($data['meeting_location'])) {
                $data['location'] = $data['meeting_location'];
            }
            if (!empty($data['meeting_date'])) {
                $data['start_date'] = $data['meeting_date'];
            }
            if (!empty($data['meeting_time'])) {
                $data['start_time'] = $data['meeting_time'];
            }
            if (!empty($data['meeting_purpose'])) {
                $data['purpose'] = $data['meeting_purpose'];
            }
            if (!empty($data['meeting_phone'])) {
                $data['applicant_phone'] = $data['meeting_phone'];
            }
            if (!empty($data['meeting_unit'])) {
                $data['unit'] = $data['meeting_unit'];
            }
            if (!empty($data['meeting_applicant_name'])) {
                $data['applicant_name'] = $data['meeting_applicant_name'];
            }
            if (!empty($data['meeting_applicant_email'])) {
                $data['applicant_email'] = $data['meeting_applicant_email'];
            }
            if (!empty($data['meeting_applicant_position'])) {
                $data['applicant_position'] = $data['meeting_applicant_position'];
            }
        }

        // Merge media specific fields if provided
        if (($data['category'] ?? '') === 'MEDIA_JURUKAMERA') {
            if (!empty($data['media_title'])) {
                $data['title'] = $data['media_title'];
            }
            if (!empty($data['media_vip'])) {
                $data['vip_attendees'] = $data['media_vip'];
            }
            if (!empty($data['media_location'])) {
                $data['location'] = $data['media_location'];
            }
            if (!empty($data['media_date'])) {
                $data['start_date'] = $data['media_date'];
            }
            if (!empty($data['media_time'])) {
                $data['start_time'] = $data['media_time'];
            }
            if (!empty($data['media_phone'])) {
                $data['applicant_phone'] = $data['media_phone'];
            }
            if (empty($data['purpose'])) {
                $data['purpose'] = !empty($data['event_agenda']) ? ('Liputan Media: ' . $data['event_agenda']) : 'Khidmat Fotografi & Videografi Majlis';
            }
            if (!empty($data['media_unit'])) {
                $data['unit'] = $data['media_unit'];
            }
            if (!empty($data['media_applicant_name'])) {
                $data['applicant_name'] = $data['media_applicant_name'];
            }
            if (!empty($data['media_applicant_email'])) {
                $data['applicant_email'] = $data['media_applicant_email'];
            }
            if (!empty($data['media_applicant_position'])) {
                $data['applicant_position'] = $data['media_applicant_position'];
            }
        }

        // Merge technical help specific fields if provided
        if (($data['category'] ?? '') === 'LAIN_LAIN') {
            if (!empty($data['technical_problem_description'])) {
                $data['purpose'] = $data['technical_problem_description'];
            }
            if (!empty($data['technical_location'])) {
                $data['location'] = $data['technical_location'];
            }
            if (!empty($data['technical_phone'])) {
                $data['applicant_phone'] = $data['technical_phone'];
            }
            if (!empty($data['technical_date'])) {
                $data['start_date'] = $data['technical_date'];
            }
            if (!empty($data['technical_title'])) {
                $data['title'] = $data['technical_title'];
            }
            if (!empty($data['technical_unit'])) {
                $data['unit'] = $data['technical_unit'];
            }
            if (!empty($data['technical_applicant_name'])) {
                $data['applicant_name'] = $data['technical_applicant_name'];
            }
            if (!empty($data['technical_applicant_email'])) {
                $data['applicant_email'] = $data['technical_applicant_email'];
            }
            if (!empty($data['technical_applicant_position'])) {
                $data['applicant_position'] = $data['technical_applicant_position'];
            }
        }

        // Handle image upload for kuarters complaints
        $attachmentUrl = null;
        $attachmentName = null;
        if ($request->hasFile('kuarters_photo')) {
            $file = $request->file('kuarters_photo');
            $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
            if (in_array($ext, $allowedExts) && (($file['size'] ?? 0) <= 12 * 1024 * 1024)) {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/kuarters';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $safeFilename = 'kuarters_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $destination = $uploadDir . '/' . $safeFilename;
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $attachmentUrl = '/uploads/kuarters/' . $safeFilename;
                    $attachmentName = $file['name'];
                }
            }
        }

        // Merge kuarters specific fields if provided
        if (($data['category'] ?? '') === 'ADUAN_KUARTERS') {
            if ($attachmentUrl) {
                $data['attachment_url'] = $attachmentUrl;
                $data['attachment_name'] = $attachmentName;
            }
            if (!empty($data['kuarters_problem_description'])) {
                $data['purpose'] = $data['kuarters_problem_description'];
            }
            $complex = trim((string)($data['kuarters_complex'] ?? ''));
            $unitNo = trim((string)($data['kuarters_unit_no'] ?? ''));
            $loc = trim($complex . ($unitNo ? ' (No: ' . $unitNo . ')' : ''));
            if (!empty($loc)) {
                $data['location'] = $loc;
            }
            if (!empty($data['kuarters_phone'])) {
                $data['applicant_phone'] = $data['kuarters_phone'];
            }
            if (!empty($data['kuarters_date'])) {
                $data['start_date'] = $data['kuarters_date'];
            }
            if (!empty($data['kuarters_title'])) {
                $data['title'] = $data['kuarters_title'];
            }
            if (!empty($data['kuarters_unit'])) {
                $data['unit'] = $data['kuarters_unit'];
            }
            if (!empty($data['kuarters_occupant_name'])) {
                $data['applicant_name'] = $data['kuarters_occupant_name'];
            }
            if (!empty($data['kuarters_email'])) {
                $data['applicant_email'] = $data['kuarters_email'];
            }
            if (!empty($data['kuarters_position'])) {
                $data['applicant_position'] = $data['kuarters_position'];
            }
        }

        // Auto-generate title if empty or not provided
        if (empty($data['title'])) {
            if (($data['category'] ?? '') === 'PEMINJAMAN_ASET') {
                $eqList = (array)($data['requested_equipment_types'] ?? []);
                $eqConfigs = app_config('services.equipment_types', []);
                $names = [];
                foreach ($eqList as $k) {
                    if (isset($eqConfigs[$k]['name'])) {
                        $names[] = $eqConfigs[$k]['name'];
                    }
                }
                if (!empty($names)) {
                    $data['title'] = 'Pinjaman Aset: ' . implode(', ', array_slice($names, 0, 2)) . (count($names) > 2 ? ' & lain-lain' : '');
                } else {
                    $data['title'] = 'Permohonan Pinjaman Aset ICT (KEW.PA-9)';
                }
            } elseif (($data['category'] ?? '') === 'MEDIA_JURUKAMERA') {
                $data['title'] = 'Liputan Khidmat Media & Dokumentasi';
            } elseif (($data['category'] ?? '') === 'SOKONGAN_MESYUARAT') {
                $data['title'] = 'Sokongan Teknikal & Mesyuarat Online';
            } elseif (($data['category'] ?? '') === 'LAIN_LAIN') {
                $techTypes = app_config('services.technical_support_types', []);
                $tKey = $data['technical_type'] ?? '';
                $tName = $techTypes[$tKey]['name'] ?? 'Aduan Kerosakan / Sokongan Teknikal';
                $data['title'] = 'Bantuan ICT: ' . $tName;
            } elseif (($data['category'] ?? '') === 'ADUAN_KUARTERS') {
                $kTypes = app_config('services.kuarters_complaint_types', []);
                $kKey = $data['kuarters_complaint_type'] ?? '';
                $kName = $kTypes[$kKey]['name'] ?? 'Kerosakan Kuarters';
                $loc = !empty($data['kuarters_complex']) ? (' - ' . $data['kuarters_complex']) : '';
                $data['title'] = 'Aduan Kuarters: ' . $kName . $loc;
            } else {
                $data['title'] = 'Permohonan Perkhidmatan ICT';
            }
        }

        // Basic validation
        if (empty($data['start_date']) || empty($data['purpose'])) {
            Session::flashInput($data);
            $this->redirect('/tickets/create', 'error', 'Sila lengkapkan tujuan permohonan dan tarikh yang diperlukan.');
        }

        // Tentukan identiti pengguna (Staf log masuk ATAU Pemohon Terbuka)
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            // Pengguna awam / tetamu: semak maklumat wajib
            if (empty($data['applicant_name']) || empty($data['applicant_email'])) {
                Session::flashInput($data);
                $this->redirect('/tickets/create', 'error', 'Sila lengkapkan nama penuh dan emel rasmi pemohon.');
            }

            $email = strtolower(trim((string)$data['applicant_email']));
            $existingUser = $this->userRepo->findByEmail($email);

            if ($existingUser) {
                $user = $existingUser;
            } else {
                // Daftar automatik akaun staf dengan kata laluan asas '123456'
                $user = $this->userRepo->create([
                    'email' => $email,
                    'name' => trim((string)$data['applicant_name']),
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'role' => 'STAF',
                    'unit' => $data['unit'] ?? 'PENTADBIRAN',
                    'position' => trim((string)($data['applicant_position'] ?? 'Pegawai')),
                    'phone' => trim((string)($data['applicant_phone'] ?? '')),
                    'is_active' => true,
                ]);
            }
        }

        try {
            $ticket = $this->ticketService->createTicket($data, $user);
            Session::clearOldInput();

            if (Auth::check()) {
                $this->redirect(
                    "/tickets/{$ticket['id']}",
                    'success',
                    "Permohonan berjaya dihantar dengan No. Rujukan: {$ticket['reference_no']}"
                );
            } else {
                // Tetamu: Arahkan ke laman penjejakan status tiket awam bersama mesej rujukan
                $this->redirect(
                    "/track?ref=" . urlencode($ticket['reference_no']),
                    'success',
                    "Permohonan anda telah berjaya dihantar dengan No. Rujukan: {$ticket['reference_no']}! Sila simpan no. rujukan ini untuk semakan status, atau log masuk (kata laluan asas: 123456) untuk melihat sejarah permohonan."
                );
            }
        } catch (\Exception $e) {
            Session::flashInput($data);
            $this->redirect('/tickets/create', 'error', 'Ralat semasa memproses permohonan: ' . $e->getMessage());
        }
    }

    /**
     * Show Ticket Details & Workflow Action Area
     */
    public function show(Request $request, string $id): void
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->abort(404, 'Permohonan tidak dijumpai.');
        }

        $user = Auth::user();
        // Permission check
        if ($user['role'] === 'STAF' && $ticket['user_id'] !== $user['id']) {
            $this->abort(403, 'Akses dinafikan. Anda hanya boleh melihat permohonan sendiri.');
        } elseif ($user['role'] === 'KETUA_UNIT' && $ticket['unit'] !== $user['unit'] && $ticket['user_id'] !== $user['id']) {
            $this->abort(403, 'Akses dinafikan. Permohonan ini bukan di bawah unit anda.');
        }

        $presented = TicketViewModel::present($ticket);
        $auditTrail = $this->auditService->getTrailForTicket($id);

        // Fetch assigned asset objects
        $assignedAssets = [];
        foreach ($ticket['assigned_asset_ids'] ?? [] as $assetId) {
            $a = $this->assetRepo->find($assetId);
            if ($a) {
                $assignedAssets[] = AssetViewModel::present($a);
            }
        }

        // Available assets for ICT assignment
        $allAssets = $this->assetRepo->all();
        $availableForAssignment = AssetViewModel::presentCollection($allAssets);

        $this->render('tickets/show', [
            'pageTitle' => "Permohonan {$ticket['reference_no']} - " . app_config('app.short_name'),
            'ticket' => $presented,
            'auditTrail' => $auditTrail,
            'assignedAssets' => $assignedAssets,
            'availableAssets' => $availableForAssignment,
            'ictStaff' => (new \App\Repositories\UserRepository())->getICTStaff(),
        ]);
    }

    /**
     * Printable Official Slip / Handover Form
     */
    public function printSlip(Request $request, string $id): void
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->abort(404, 'Permohonan tidak dijumpai.');
        }

        $presented = TicketViewModel::present($ticket);

        $assignedAssets = [];
        foreach ($ticket['assigned_asset_ids'] ?? [] as $assetId) {
            $a = $this->assetRepo->find($assetId);
            if ($a) {
                $assignedAssets[] = AssetViewModel::present($a);
            }
        }

        $this->render('tickets/print', [
            'pageTitle' => "Borang Permohonan & Serahan Aset - {$ticket['reference_no']}",
            'ticket' => $presented,
            'assignedAssets' => $assignedAssets,
        ], 'print');
    }

    /**
     * Cancel Ticket
     */
    public function cancel(Request $request, string $id): void
    {
        $reason = (string) $request->input('reason', 'Dibatalkan oleh pemohon');
        $user = Auth::user();

        $success = $this->ticketService->cancelTicket($id, $reason, $user);

        if ($success) {
            $this->redirect("/tickets/{$id}", 'info', 'Permohonan telah berjaya dibatalkan.');
        } else {
            $this->redirect("/tickets/{$id}", 'error', 'Permohonan tidak dapat dibatalkan.');
        }
    }

    /**
     * Delete Ticket Permanently (Khusus farhah@johor.gov.my sahaja)
     */
    public function delete(Request $request, string $id): void
    {
        $user = Auth::user();

        if (($user['email'] ?? '') !== 'farhah@johor.gov.my') {
            $this->abort(403, 'Akses dinafikan. Hanya Pentadbir Khas (farhah@johor.gov.my) dibenarkan memadam rekod permohonan.');
        }

        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            $this->redirect('/tickets', 'error', 'Rekod permohonan tidak dijumpai.');
        }

        $refNo = $ticket['reference_no'] ?? $id;
        $success = $this->ticketService->deleteTicket($id, $user);

        if ($success) {
            $this->redirect('/tickets', 'success', "Permohonan {$refNo} telah berjaya dipadam secara kekal dari sistem.");
        } else {
            $this->redirect('/tickets', 'error', 'Gagal memadam permohonan.');
        }
    }
}
