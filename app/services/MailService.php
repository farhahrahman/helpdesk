<?php
declare(strict_types=1);

namespace App\Services;

/**
 * Enterprise Mail Notification Service
 */
class MailService
{
    private string $fromEmail;
    private string $fromName;

    public function __construct()
    {
        $this->fromEmail = (string) app_config('mail.from_email', 'noreply.ictbkp@johor.gov.my');
        $this->fromName = (string) app_config('mail.from_name', 'Helpdesk ICT BKP');
    }

    /**
     * Send email confirmation when a ticket is created
     */
    public function sendTicketConfirmation(array $ticket): bool
    {
        $recipient = trim((string)($ticket['applicant_email'] ?? ''));
        if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $refNo = $ticket['reference_no'] ?? '';
        $title = $ticket['title'] ?? 'Permohonan Perkhidmatan ICT';
        $applicantName = $ticket['applicant_name'] ?? 'Pemohon';
        $unit = $ticket['unit_short_name'] ?? $ticket['unit_name'] ?? 'BKP';
        $trackUrl = full_url('/track/' . urlencode($refNo));

        $subject = "[ICT BKP] Pengesahan Permohonan: {$refNo} - {$title}";

        $html = "<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; color: #1e293b; }
        .card { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .header { background: #1d3d75; color: #ffffff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 19px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { margin: 4px 0 0; font-size: 11px; opacity: 0.85; }
        .content { padding: 28px 24px; }
        .badge { display: inline-block; background: #eff6ff; color: #1d3d75; padding: 8px 18px; border-radius: 10px; font-family: monospace; font-size: 15px; font-weight: bold; border: 1px solid #bfdbfe; }
        .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 12px; }
        .details-table td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; }
        .details-table td.label { width: 35%; color: #64748b; font-weight: 600; }
        .details-table td.val { color: #0f172a; font-weight: 700; }
        .btn { display: inline-block; background: #1d3d75; color: #ffffff !important; padding: 12px 24px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 13px; margin: 16px 0; }
        .footer { background: #f8fafc; padding: 16px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class='card'>
        <div class='header'>
            <h1>HELPDESK ICT BKP</h1>
            <p>Bahagian Khidmat Pengurusan, Pejabat Setiausaha Kerajaan Johor</p>
        </div>
        <div class='content'>
            <p style='font-size: 13px; margin-top: 0;'>Salam Sejahtera <strong>" . htmlspecialchars($applicantName, ENT_QUOTES, 'UTF-8') . "</strong>,</p>
            <p style='font-size: 12px; line-height: 1.6; color: #475569;'>Permohonan / aduan anda telah berjaya didaftarkan ke dalam sistem. Sila simpan nombor rujukan di bawah untuk menyemak status permohonan anda:</p>
            
            <div style='text-align: center; margin: 20px 0;'>
                <div class='badge'>" . htmlspecialchars($refNo, ENT_QUOTES, 'UTF-8') . "</div>
            </div>

            <table class='details-table'>
                <tr>
                    <td class='label'>Tugasan / Tajuk:</td>
                    <td class='val'>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</td>
                </tr>
                <tr>
                    <td class='label'>Unit / Bahagian:</td>
                    <td class='val'>" . htmlspecialchars($unit, ENT_QUOTES, 'UTF-8') . "</td>
                </tr>
                <tr>
                    <td class='label'>Status Aliran Kerja:</td>
                    <td class='val' style='color: #d97706;'>BELUM SELESAI (Menunggu Perakuan)</td>
                </tr>
            </table>

            <div style='text-align: center;'>
                <a href='" . htmlspecialchars($trackUrl, ENT_QUOTES, 'UTF-8') . "' class='btn' target='_blank'>Semak Status Tiket Anda &rarr;</a>
            </div>

            <p style='font-size: 11px; color: #64748b; line-height: 1.5; margin-top: 20px;'>
                * Peringatan: Anda tidak perlu log masuk atau mendaftar akaun untuk menyemak permohonan ini. Hanya klik pautan di atas atau masukkan no. tiket pada bila-bila masa.
            </p>
        </div>
        <div class='footer'>
            Emel ini dijana secara automatik oleh Sistem Helpdesk ICT BKP. Sila jangan balas emel ini.<br>
            Seksyen ICT, Bahagian Khidmat Pengurusan, Aras 1, Bangunan Dato' Jaafar Muhammad.
        </div>
    </div>
</body>
</html>";

        return $this->sendHtmlMail($recipient, $subject, $html);
    }

    /**
     * Dispatch HTML Mail via PHP mail
     */
    protected function sendHtmlMail(string $to, string $subject, string $html): bool
    {
        try {
            $headers = [];
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=UTF-8';
            $headers[] = 'From: ' . $this->fromName . ' <' . $this->fromEmail . '>';
            $headers[] = 'Reply-To: ' . (string) app_config('mail.reply_to', 'ict@bkp.gov.my');
            $headers[] = 'X-Mailer: PHP/' . phpversion();

            return @mail($to, $subject, $html, implode("\r\n", $headers));
        } catch (\Throwable $e) {
            return false;
        }
    }
}
