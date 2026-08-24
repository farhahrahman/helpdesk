<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\AssetRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Services\TicketService;
use App\ViewModels\AssetViewModel;
use App\ViewModels\TicketViewModel;

/**
 * Public Front Portal Controller (Paparan Muka Depan & Semakan Status No. Tiket)
 */
class HomeController extends BaseController
{
    private TicketRepository $ticketRepo;
    private TicketService $ticketService;
    private AssetRepository $assetRepo;
    private UserRepository $userRepo;

    public function __construct(
        ?TicketRepository $ticketRepo = null,
        ?TicketService $ticketService = null,
        ?AssetRepository $assetRepo = null,
        ?UserRepository $userRepo = null
    ) {
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->ticketService = $ticketService ?? new TicketService();
        $this->assetRepo = $assetRepo ?? new AssetRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    /**
     * Public Landing Page: Borang Permohonan & Kategori Servis
     */
    public function index(Request $request): void
    {
        $this->render('home/index', [
            'pageTitle' => 'Portal Permohonan Mesyuarat, Aset ICT & Khidmat Media - ' . app_config('app.name'),
            'categories' => app_config('services.categories', []),
            'equipmentTypes' => app_config('services.equipment_types', []),
            'units' => app_config('units', []),
        ], 'public');
    }

    /**
     * Semakan Status Permohonan Menggunakan No. Tiket
     */
    public function track(Request $request): void
    {
        $refNo = trim((string)$request->input('ref', ''));
        $ticket = null;

        if (!empty($refNo)) {
            $rawTicket = $this->ticketRepo->findByReference($refNo);
            if ($rawTicket) {
                $ticket = TicketViewModel::present($rawTicket);
            }
        }

        $this->render('home/track', [
            'pageTitle' => 'Semakan Status No. Tiket: ' . ($refNo ?: 'Carian') . ' - ' . app_config('app.short_name'),
            'refNo' => $refNo,
            'ticket' => $ticket,
        ], 'public');
    }

    /**
     * Direct URL Tracking: /track/{ref}
     */
    public function trackByRef(Request $request, string $ref): void
    {
        $cleanRef = urldecode(trim($ref));
        $rawTicket = $this->ticketRepo->findByReference($cleanRef);
        $ticket = $rawTicket ? TicketViewModel::present($rawTicket) : null;

        $this->render('home/track', [
            'pageTitle' => 'Semakan Status No. Tiket: ' . $cleanRef . ' - ' . app_config('app.short_name'),
            'refNo' => $cleanRef,
            'ticket' => $ticket,
        ], 'public');
    }

    /**
     * Process Public Form Submission
     */
    public function submitPublic(Request $request): void
    {
        $data = $request->all();

        // Basic validation
        if (empty($data['title']) || empty($data['start_date']) || empty($data['applicant_name']) || empty($data['applicant_email'])) {
            Session::flashInput($data);
            $this->redirect('/#permohonan-borang', 'error', 'Sila lengkapkan tajuk program, tarikh acara, dan maklumat pemohon.');
        }

        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            try {
                $ticket = $this->ticketService->createTicket($data, $user);
                Session::clearOldInput();
                $this->redirect(
                    '/track?ref=' . urlencode($ticket['reference_no']),
                    'success',
                    "Permohonan anda berjaya dihantar! No. Tiket rasmi: {$ticket['reference_no']}"
                );
            } catch (\Exception $e) {
                Session::flashInput($data);
                $this->redirect('/#permohonan-borang', 'error', 'Ralat semasa memproses permohonan: ' . $e->getMessage());
            }
            return;
        }

        // If NOT logged in: Save draft into session and direct to login
        Session::set('_pending_ticket', $data);
        Session::flash('info', 'Borang permohonan telah disimpan! Sila log masuk ke akaun anda untuk menjana No. Tiket rasmi secara automatik.');
        $this->redirect('/login');
    }
}
