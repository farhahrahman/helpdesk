<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use ZipArchive;

/**
 * Enterprise Data Restore Service for Helpdesk ICTBKP
 */
class RestoreService
{
    private string $dataPath;
    private BackupService $backupService;
    private AuditService $audit;

    public function __construct(?BackupService $backupService = null, ?AuditService $audit = null)
    {
        $baseDir = dirname(__DIR__, 2);
        $this->dataPath = $baseDir . DIRECTORY_SEPARATOR . 'data';
        $this->backupService = $backupService ?? new BackupService();
        $this->audit = $audit ?? new AuditService();
    }

    /**
     * Restore data from a verified backup archive
     * 
     * @param string $filename
     * @return array [success => bool, message => string, snapshot => string, restored_counts => array]
     */
    public function restoreFromBackup(string $filename): array
    {
        $zipPath = $this->backupService->getSafeBackupPath($filename);
        if (!$zipPath) {
            return [
                'success' => false,
                'message' => 'Fail arkib sandaran tidak ditemui atau nama fail tidak sah.',
            ];
        }

        // 1. Verify archive
        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return [
                'success' => false,
                'message' => 'Arkib ZIP rosak atau tidak dapat dibuka.',
            ];
        }

        // Check if data/tickets.json exists in zip
        $hasTickets = ($zip->locateName('data/tickets.json') !== false);
        if (!$hasTickets) {
            $zip->close();
            return [
                'success' => false,
                'message' => 'Arkib tidak mengandungi data/tickets.json yang sah.',
            ];
        }

        // Validate JSON files inside zip
        $jsonFiles = ['tickets.json', 'counters.json', 'users.json', 'assets.json', 'units.json', 'positions.json'];
        $restoredCounts = [];

        foreach ($jsonFiles as $jf) {
            $content = $zip->getFromName('data/' . $jf);
            if ($content !== false) {
                $decoded = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $zip->close();
                    return [
                        'success' => false,
                        'message' => "Fail {$jf} di dalam arkib mengandungi ralat sintaks JSON.",
                    ];
                }
                $restoredCounts[str_replace('.json', '', $jf)] = count($decoded);
            }
        }

        // 2. MANDATORY PRE-RESTORE SAFETY SNAPSHOT
        $snapshotResult = $this->backupService->createBackup('PRE_RESTORE');
        if (!$snapshotResult['success']) {
            $zip->close();
            return [
                'success' => false,
                'message' => 'Gagal mengambil salinan keselamatan pra-pemulihan. Proses pemulihan dibatalkan demi keselamatan data.',
            ];
        }
        $snapshotFilename = $snapshotResult['filename'];

        // 3. Atomically overwrite data/ files from zip
        foreach ($jsonFiles as $jf) {
            $content = $zip->getFromName('data/' . $jf);
            if ($content !== false) {
                $dest = $this->dataPath . DIRECTORY_SEPARATOR . $jf;
                // Atomic write with temp file
                $temp = tempnam($this->dataPath, 'rst_tmp_');
                if ($temp !== false) {
                    file_put_contents($temp, $content);
                    if (!@rename($temp, $dest)) {
                        @unlink($dest);
                        @rename($temp, $dest);
                    }
                } else {
                    file_put_contents($dest, $content);
                }
            }
        }

        $zip->close();

        // 4. Audit Trail
        $user = Auth::user();
        $adminName = $user ? $user['name'] . ' (' . $user['email'] . ')' : 'Pentadbir';
        $this->audit->log('DATA_RESTORED', "Pemulihan data berjaya dilaksanakan dari arkib {$filename}. Salinan keselamatan disimpan sebagai {$snapshotFilename}.", null, [
            'restored_from' => $filename,
            'pre_restore_snapshot' => $snapshotFilename,
            'restored_by' => $adminName,
            'restored_counts' => $restoredCounts,
        ]);

        return [
            'success' => true,
            'message' => "Pangkalan data berjaya dipulihkan dari fail {$filename}!",
            'snapshot' => $snapshotFilename,
            'restored_counts' => $restoredCounts,
        ];
    }
}
