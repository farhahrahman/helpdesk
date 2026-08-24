<?php
declare(strict_types=1);

/**
 * Enterprise Application Configuration
 * Project: Helpdesk ICTBKP
 */

return [
    'name' => 'Sistem Helpdesk & Pengurusan Permohonan ICT BKP',
    'short_name' => 'ICTBKP Helpdesk',
    'department' => 'Bahagian Khidmat Pengurusan',
    'organization' => 'Pejabat Setiausaha Kerajaan Negeri',
    'version' => '3.0.0-ENTERPRISE',
    'env' => 'production',
    'debug' => false,
    'timezone' => 'Asia/Kuala_Lumpur',
    'locale' => 'ms_MY',
    'base_url' => '/helpdesk/public', // Laragon standard subfolder path
    'data_path' => dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'data',
    'session_lifetime' => 7200, // 2 hours
];
