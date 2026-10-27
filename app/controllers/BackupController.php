<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\AuthService;
use App\Services\BackupService;
use App\Services\RestoreService;
use App\Services\AuditService;

/**
 * Controller for Enterprise Backup & Data Recovery
 */
class BackupController extends BaseController
{
    private BackupService $backupService;
    private RestoreService $restoreService;
    private AuthService $authService;
    private AuditService $auditService;

    public function __construct()
    {
        $this->backupService = new BackupService();
        $this->restoreService = new RestoreService($this->backupService);
        $this->authService = new AuthService();
        $this->auditService = new AuditService();
    }

    /**
     * Display the Backup Management Dashboard
     */
    public function index(Request $request): void
    {
        $backups = $this->backupService->getBackups();

        // Get current live database counts
        $baseDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'data';
        $ticketsCount = 0;
        $usersCount = 0;
        $assetsCount = 0;

        if (file_exists($baseDir . DIRECTORY_SEPARATOR . 'tickets.json')) {
            $t = json_decode(file_get_contents($baseDir . DIRECTORY_SEPARATOR . 'tickets.json'), true);
            $ticketsCount = is_array($t) ? count($t) : 0;
        }
        if (file_exists($baseDir . DIRECTORY_SEPARATOR . 'users.json')) {
            $u = json_decode(file_get_contents($baseDir . DIRECTORY_SEPARATOR . 'users.json'), true);
            $usersCount = is_array($u) ? count($u) : 0;
        }
        if (file_exists($baseDir . DIRECTORY_SEPARATOR . 'assets.json')) {
            $a = json_decode(file_get_contents($baseDir . DIRECTORY_SEPARATOR . 'assets.json'), true);
            $assetsCount = is_array($a) ? count($a) : 0;
        }

        // Recent backup audit trails
        $auditLogs = $this->auditService->getRecentLogs(25);
        $backupLogs = array_filter($auditLogs, function ($log) {
            $action = $log['action'] ?? '';
            return str_starts_with($action, 'BACKUP_') || $action === 'DATA_RESTORED';
        });

        $this->render('backups/index', [
            'pageTitle' => 'Pusat Kawalan Sandaran & Pemulihan Data - Helpdesk ICT BKP',
            'backups' => $backups,
            'currentCounts' => [
                'tickets' => $ticketsCount,
                'users' => $usersCount,
                'assets' => $assetsCount,
            ],
            'recentLogs' => array_values($backupLogs),
            'user' => Auth::user(),
        ]);
    }

    /**
     * Handle manual backup trigger
     */
    public function create(Request $request): void
    {
        $email = trim((string) $request->input('email_notification', ''));
        $email = !empty($email) ? $email : null;

        $result = $this->backupService->createBackup('MANUAL', $email);

        if ($result['success']) {
            $msg = "Sandaran manual berjaya dicipta: <strong>{$result['filename']}</strong> (" . round($result['size'] / 1024, 1) . " KB).";
            if ($email) {
                $msg .= $result['email_status'] 
                    ? " Salinan fail arkib telah dihantar ke <strong>" . e($email) . "</strong>." 
                    : " (Nota: Penghantaran emel ke " . e($email) . " tidak berjaya, namun fail sandaran selamat tersimpan di pelayan).";
            }
            $this->redirect('/backups', 'success', $msg);
        } else {
            $this->redirect('/backups', 'error', $result['message']);
        }
    }

    /**
     * Authenticated secure stream download
     */
    public function download(Request $request, string $filename): void
    {
        $path = $this->backupService->getSafeBackupPath($filename);
        if (!$path || !file_exists($path)) {
            $this->redirect('/backups', 'error', 'Fail sandaran yang diminta tidak ditemui.');
            return;
        }

        $cleanName = basename($path);
        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $cleanName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));

        // Flush output buffer to prevent memory issues
        if (ob_get_level()) {
            ob_end_clean();
        }

        readfile($path);
        exit;
    }

    /**
     * Handle restoration
     */
    public function restore(Request $request): void
    {
        $filename = (string) $request->input('filename', '');
        $confirmPhrase = trim((string) $request->input('confirm_phrase', ''));
        $password = (string) $request->raw('password', '');

        // 1. Confirm phrase check
        if ($confirmPhrase !== 'PULIHKAN DATA') {
            $this->redirect('/backups', 'error', 'Frasa pengesahan tidak tepat. Sila taip "PULIHKAN DATA" untuk mengesahkan operasi.');
            return;
        }

        // 2. Re-authenticate admin
        $currentUser = Auth::user();
        $adminEmail = $currentUser['email'] ?? '';
        if (!$this->authService->attempt($adminEmail, $password)) {
            $this->redirect('/backups', 'error', 'Kata laluan pentadbir tidak sah. Pemulihan dibatalkan demi keselamatan sistem.');
            return;
        }

        // 3. Perform restoration
        $res = $this->restoreService->restoreFromBackup($filename);

        if ($res['success']) {
            $counts = $res['restored_counts'] ?? [];
            $summary = "Pulih: " . ($counts['tickets'] ?? 0) . " Tiket, " . ($counts['users'] ?? 0) . " Staf, " . ($counts['assets'] ?? 0) . " Aset.";
            $msg = "{$res['message']} ({$summary}). Salinan keselamatan sebelum pemulihan telah disimpan sebagai <strong>{$res['snapshot']}</strong>.";
            $this->redirect('/backups', 'success', $msg);
        } else {
            $this->redirect('/backups', 'error', $res['message']);
        }
    }

    /**
     * Delete backup archive
     */
    public function delete(Request $request, string $filename): void
    {
        if ($this->backupService->deleteBackup($filename)) {
            $this->redirect('/backups', 'success', "Fail sandaran {$filename} telah dipadam.");
        } else {
            $this->redirect('/backups', 'error', 'Gagal memadam fail sandaran (Fail snapshot pra-pemulihan dilindungi daripada pemadaman).');
        }
    }
}
