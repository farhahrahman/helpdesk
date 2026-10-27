<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Storage\JsonStorageEngine;
use ZipArchive;

/**
 * Enterprise Backup Service for Helpdesk ICTBKP
 */
class BackupService
{
    private string $storagePath;
    private string $dataPath;
    private string $uploadsPath;
    private AuditService $audit;

    public function __construct(?AuditService $audit = null)
    {
        $baseDir = dirname(__DIR__, 2);
        $this->storagePath = $baseDir . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'backups';
        $this->dataPath = $baseDir . DIRECTORY_SEPARATOR . 'data';
        $this->uploadsPath = $baseDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads';
        $this->audit = $audit ?? new AuditService();

        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0755, true);
        }
    }

    /**
     * Create a complete backup archive
     * 
     * @param string $type MANUAL, AUTO_DAILY, PRE_RESTORE
     * @param string|null $emailNotification Optional email to send backup copy to (e.g. Gmail)
     * @return array [success => bool, filename => string, path => string, size => int, message => string]
     */
    public function createBackup(string $type = 'MANUAL', ?string $emailNotification = null): array
    {
        $timestamp = date('Y-m-d_His');
        $randomHash = substr(bin2hex(random_bytes(4)), 0, 6);
        $prefix = ($type === 'PRE_RESTORE') ? 'snapshot_PRE_RESTORE' : 'backup_helpdesk_' . strtoupper($type);
        $filename = "{$prefix}_{$timestamp}_{$randomHash}.zip";
        $zipPath = $this->storagePath . DIRECTORY_SEPARATOR . $filename;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return [
                'success' => false,
                'message' => 'Gagal mencipta arkib ZIP di storan sandaran.',
            ];
        }

        // Count data records
        $counts = [];
        $checksums = [];

        $jsonFiles = ['tickets.json', 'counters.json', 'users.json', 'assets.json', 'units.json', 'positions.json', 'audit_logs.json'];
        foreach ($jsonFiles as $jf) {
            $src = $this->dataPath . DIRECTORY_SEPARATOR . $jf;
            if (file_exists($src)) {
                $content = file_get_contents($src);
                $checksums[$jf] = hash('sha256', $content);
                $decoded = json_decode($content, true);
                $counts[str_replace('.json', '', $jf)] = is_array($decoded) ? count($decoded) : 0;
                $zip->addFromString('data/' . $jf, $content);
            }
        }

        // Pack uploads if exists
        if (is_dir($this->uploadsPath)) {
            $this->addFolderToZip($this->uploadsPath, $zip, 'uploads');
        }

        $user = Auth::user();
        $creator = $user ? ($user['name'] . ' (' . $user['email'] . ')') : 'SISTEM_AUTOMATIK';

        $manifest = [
            'system' => 'Helpdesk ICTBKP',
            'version' => app_config('app.version', '3.0.0-ENTERPRISE'),
            'backup_id' => 'BAK-' . date('Ymd-His'),
            'type' => $type,
            'created_at' => date('c'),
            'created_by' => $creator,
            'record_counts' => $counts,
            'checksums' => $checksums,
        ];

        $zip->addFromString('manifest.json', json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $zip->close();

        $fileSize = file_exists($zipPath) ? filesize($zipPath) : 0;

        // Audit log
        $this->audit->log('BACKUP_CREATED', "Sandaran data ({$type}) berjaya dicipta: {$filename} (" . round($fileSize / 1024, 2) . " KB)", null, [
            'filename' => $filename,
            'type' => $type,
            'size' => $fileSize,
            'counts' => $counts,
        ]);

        // Send to Gmail if requested
        $emailStatus = null;
        if (!empty($emailNotification) && filter_var($emailNotification, FILTER_VALIDATE_EMAIL)) {
            $emailStatus = $this->sendBackupToEmail($zipPath, $emailNotification, $manifest, $filename);
        }

        return [
            'success' => true,
            'filename' => $filename,
            'path' => $zipPath,
            'size' => $fileSize,
            'counts' => $counts,
            'email_status' => $emailStatus,
            'message' => "Sandaran data berjaya dicipta ({$filename}).",
        ];
    }

    /**
     * Send backup archive to Gmail / Admin email
     */
    public function sendBackupToEmail(string $zipPath, string $recipientEmail, array $manifest, string $filename): bool
    {
        $subject = "[HELPDESK BKP] Salinan Sandaran Data Rasmi - " . date('d/m/Y H:i');
        $sizeKb = round(filesize($zipPath) / 1024, 1);
        $ticketsCount = $manifest['record_counts']['tickets'] ?? 0;
        $usersCount = $manifest['record_counts']['users'] ?? 0;
        $assetsCount = $manifest['record_counts']['assets'] ?? 0;

        $bodyText = "SALINAN SANDARAN KESELAMATAN DATA HELPDESK ICT BKP\n"
            . "--------------------------------------------------\n"
            . "Tarikh Sandaran : " . date('d/m/Y H:i:s') . "\n"
            . "Nama Fail Arkib : {$filename}\n"
            . "Saiz Fail       : {$sizeKb} KB\n"
            . "Jenis Sandaran  : {$manifest['type']}\n"
            . "Jumlah Tiket    : {$ticketsCount} rekod\n"
            . "Jumlah Pengguna : {$usersCount} rekod\n"
            . "Jumlah Aset     : {$assetsCount} rekod\n\n"
            . "NOTA KESELAMATAN:\n"
            . "Fail sandaran lengkap dilampirkan bersama emel ini. Sila simpan arkib ini di tempat selamat untuk tujuan pemulihan luar talian jika berlaku sebarang kecemasan pada pelayan.";

        // Read and encode file attachment
        $fileData = file_get_contents($zipPath);
        $encodedData = chunk_split(base64_encode($fileData));
        $boundary = md5((string)time());

        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'From: Helpdesk ICT BKP <noreply.ictbkp@johor.gov.my>';
        $headers[] = 'Reply-To: ict@bkp.gov.my';
        $headers[] = "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

        $message = "--{$boundary}\r\n";
        $message .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message .= $bodyText . "\r\n\r\n";

        $message .= "--{$boundary}\r\n";
        $message .= "Content-Type: application/zip; name=\"{$filename}\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
        $message .= $encodedData . "\r\n\r\n";
        $message .= "--{$boundary}--";

        $sent = @mail($recipientEmail, $subject, $message, implode("\r\n", $headers));

        $this->audit->log('BACKUP_EMAIL_DISPATCH', ($sent ? "Salinan sandaran berjaya dihantar ke {$recipientEmail}" : "Percubaan penghantaran emel sandaran ke {$recipientEmail} gagal."), null, [
            'email' => $recipientEmail,
            'filename' => $filename,
            'success' => $sent,
        ]);

        return $sent;
    }

    /**
     * Get list of all available backups
     */
    public function getBackups(): array
    {
        if (!is_dir($this->storagePath)) {
            return [];
        }

        $files = scandir($this->storagePath);
        $backups = [];

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || !str_ends_with($file, '.zip')) {
                continue;
            }

            $filePath = $this->storagePath . DIRECTORY_SEPARATOR . $file;
            $size = filesize($filePath);
            $mtime = filemtime($filePath);

            // Read manifest inside zip if possible
            $meta = $this->readManifestFromZip($filePath);

            $type = 'MANUAL';
            if (str_contains($file, 'PRE_RESTORE')) {
                $type = 'PRE_RESTORE';
            } elseif (str_contains($file, 'AUTO_DAILY')) {
                $type = 'AUTO_DAILY';
            } elseif (isset($meta['type'])) {
                $type = $meta['type'];
            }

            $backups[] = [
                'filename' => $file,
                'path' => $filePath,
                'size' => $size,
                'size_formatted' => $this->formatBytes($size),
                'created_at' => date('Y-m-d H:i:s', $mtime),
                'timestamp' => $mtime,
                'type' => $type,
                'creator' => $meta['created_by'] ?? 'Pentadbir Sistem',
                'record_counts' => $meta['record_counts'] ?? [],
                'is_snapshot' => ($type === 'PRE_RESTORE'),
            ];
        }

        // Sort descending by timestamp
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return $backups;
    }

    /**
     * Get validated path for download
     */
    public function getSafeBackupPath(string $filename): ?string
    {
        $cleanName = basename($filename);
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+\.zip$/', $cleanName)) {
            return null;
        }

        $path = $this->storagePath . DIRECTORY_SEPARATOR . $cleanName;
        return (file_exists($path) && is_file($path)) ? $path : null;
    }

    /**
     * Delete a backup file (Cannot delete PRE_RESTORE snapshot)
     */
    public function deleteBackup(string $filename): bool
    {
        if (str_contains($filename, 'PRE_RESTORE')) {
            return false; // Protected
        }

        $path = $this->getSafeBackupPath($filename);
        if ($path && unlink($path)) {
            $this->audit->log('BACKUP_DELETED', "Fail sandaran dipadam: {$filename}");
            return true;
        }
        return false;
    }

    /**
     * Read manifest.json without extracting whole zip
     */
    private function readManifestFromZip(string $zipPath): ?array
    {
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true) {
            $json = $zip->getFromName('manifest.json');
            $zip->close();
            if ($json) {
                return json_decode($json, true);
            }
        }
        return null;
    }

    private function addFolderToZip(string $folder, ZipArchive $zip, string $zipSubFolder): void
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen(realpath($folder)) + 1);
            if ($file->isDir()) {
                $zip->addEmptyDir($zipSubFolder . '/' . str_replace('\\', '/', $relativePath));
            } elseif ($file->isFile() && basename($filePath) !== '.gitkeep') {
                $zip->addFile($filePath, $zipSubFolder . '/' . str_replace('\\', '/', $relativePath));
            }
        }
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        return round($bytes / 1024, 1) . ' KB';
    }
}
