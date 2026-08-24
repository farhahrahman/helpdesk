<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;

/**
 * Enterprise Base Controller
 */
abstract class BaseController
{
    protected function render(string $template, array $data = [], ?string $layout = 'app'): void
    {
        // Inject common layout variables
        $data['currentUser'] = Auth::user();
        $data['appName'] = app_config('app.name');
        $data['shortName'] = app_config('app.short_name');
        $data['currentUri'] = (new Request())->uri();

        View::render($template, $data, $layout);
    }

    protected function redirect(string $url, string $flashType = '', string $flashMessage = ''): void
    {
        if (!empty($flashType) && !empty($flashMessage)) {
            Session::flash($flashType, $flashMessage);
        }
        Response::redirect($url);
    }

    protected function json(mixed $data, int $statusCode = 200): void
    {
        Response::json($data, $statusCode);
    }

    protected function abort(int $statusCode = 404, string $message = 'Halaman Tidak Dijumpai'): void
    {
        Response::abort($statusCode, $message);
    }
}
