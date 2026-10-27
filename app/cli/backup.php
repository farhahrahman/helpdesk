<?php
declare(strict_types=1);

/**
 * Enterprise Scheduled Backup CLI Runner
 * Usage: php app/cli/backup.php [--email=you@gmail.com]
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

date_default_timezone_set('Asia/Kuala_Lumpur');

use App\Services\BackupService;

echo "[ " . date('Y-m-d H:i:s') . " ] Memulakan tugas sandaran automatik Helpdesk ICTBKP...\n";

$options = getopt('', ['email::', 'type::']);
$email = $options['email'] ?? null;
$type = strtoupper((string)($options['type'] ?? 'AUTO_DAILY'));

$backupService = new BackupService();
$result = $backupService->createBackup($type, $email);

if ($result['success']) {
    echo "[ BERJAYA ] Fail Sandaran Dicipta: {$result['filename']} (" . round($result['size'] / 1024, 2) . " KB)\n";
    if ($email) {
        echo "[ EMEL ] Salinan sandaran dihantar ke: {$email} (" . ($result['email_status'] ? 'Berjaya' : 'Gagal') . ")\n";
    }
    exit(0);
} else {
    echo "[ GAGAL ] {$result['message']}\n";
    exit(1);
}
