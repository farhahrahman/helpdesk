<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise HTTP Response Handler
 */
class Response
{
    /**
     * Send HTTP redirect
     */
    public static function redirect(string $url, int $statusCode = 302): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) && !str_starts_with($url, '/')) {
            $url = url($url);
        }
        http_response_code($statusCode);
        header('Location: ' . $url);
        exit;
    }

    /**
     * Send JSON response
     */
    public static function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Set HTTP status and exit with error message
     */
    public static function abort(int $statusCode = 404, string $message = 'Halaman Tidak Dijumpai'): void
    {
        http_response_code($statusCode);
        $title = $statusCode . ' - ' . $message;
        
        // Render simple enterprise styled error page if View is not available
        echo "<!DOCTYPE html>
<html lang=\"ms\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>" . e($title) . "</title>
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"bg-slate-50 font-['Inter',sans-serif] min-h-screen flex items-center justify-center p-4\">
    <div class=\"max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center\">
        <div class=\"w-16 h-16 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4\">
            <svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\"></path></svg>
        </div>
        <h1 class=\"text-2xl font-bold text-slate-900 mb-2\">Ralat " . e((string)$statusCode) . "</h1>
        <p class=\"text-sm text-slate-600 mb-6\">" . e($message) . "</p>
        <a href=\"" . e(url('/')) . "\" class=\"inline-flex items-center px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg transition-colors shadow-sm\">
            Kembali ke Papan Pemuka
        </a>
    </div>
</body>
</html>";
        exit;
    }
}
