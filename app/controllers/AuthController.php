<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Services\AuthService;
use App\Services\TicketService;

/**
 * Authentication Controller
 */
class AuthController extends BaseController
{
    private AuthService $authService;
    private TicketService $ticketService;

    public function __construct(?AuthService $authService = null, ?TicketService $ticketService = null)
    {
        $this->authService = $authService ?? new AuthService();
        $this->ticketService = $ticketService ?? new TicketService();
    }

    /**
     * Show login screen
     */
    public function showLogin(Request $request): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }

        $this->render('auth/login', [
            'pageTitle' => 'Log Masuk - Sistem Helpdesk ICTBKP',
        ], 'auth');
    }

    /**
     * Handle login submission
     */
    public function handleLogin(Request $request): void
    {
        $email = (string) $request->input('email');
        $password = (string) $request->raw('password');

        if (empty($email) || empty($password)) {
            Session::flashInput(['email' => $email]);
            $this->redirect('/login', 'error', 'Sila masukkan emel rasmi dan kata laluan.');
        }

        $success = $this->authService->attempt($email, $password);

        if ($success) {
            $user = Auth::user();

            // Check if there is a pending ticket draft from front page public submission
            if (Session::has('_pending_ticket')) {
                $pendingTicket = Session::get('_pending_ticket');
                Session::remove('_pending_ticket');
                try {
                    $ticket = $this->ticketService->createTicket($pendingTicket, $user);
                    $this->redirect(
                        '/track?ref=' . urlencode($ticket['reference_no']),
                        'success',
                        "Log masuk berjaya! Permohonan anda telah didaftarkan dengan No. Tiket rasmi: {$ticket['reference_no']}"
                    );
                    return;
                } catch (\Exception $e) {
                    $this->redirect('/tickets/create', 'error', 'Permohonan tertangguh gagal diproses: ' . $e->getMessage());
                    return;
                }
            }

            $this->redirect('/dashboard', 'success', 'Log masuk berjaya.');
        } else {
            Session::flashInput(['email' => $email]);
            $this->redirect('/login', 'error', 'Emel atau kata laluan tidak sah. Sila cuba lagi.');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request): void
    {
        $this->authService->logout();
        $this->redirect('/login', 'info', 'Anda telah selamat log keluar.');
    }
}
