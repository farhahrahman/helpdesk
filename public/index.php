<?php
declare(strict_types=1);

/**
 * Enterprise Front Controller
 * Project: Helpdesk ICTBKP
 */

// Define error reporting for enterprise runtime
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;

// Initialize session
Session::start();

// Initialize Request & Router
$request = new Request();
$router = new Router($request);

// -------------------------------------------------------------
// ROUTES DEFINITION
// -------------------------------------------------------------

// Public Front Portal & Ticket Status Tracking
$router->get('/', 'HomeController@index');
$router->post('/submit', 'HomeController@submitPublic', ['csrf']);
$router->get('/track', 'HomeController@track');
$router->get('/track/{ref}', 'HomeController@trackByRef');

// Authentication
$router->get('/login', 'AuthController@showLogin', ['guest']);
$router->post('/login', 'AuthController@handleLogin', ['guest', 'csrf']);
$router->get('/logout', 'AuthController@logout');
$router->post('/logout', 'AuthController@logout', ['auth']);

// Dashboard & Calendar
$router->get('/dashboard', 'DashboardController@index', ['auth']);
$router->get('/calendar', 'DashboardController@calendar', ['auth']);

// Tickets / Service Requests (Borang Terbuka & Aliran Log Masuk Semasa Hantar)
$router->get('/tickets', 'TicketController@index', ['auth']);
$router->get('/tickets/create', 'TicketController@create');
$router->get('/apply', 'TicketController@create');
$router->post('/tickets', 'TicketController@store', ['csrf']);
$router->get('/tickets/{id}', 'TicketController@show', ['auth']);
$router->get('/tickets/{id}/print', 'TicketController@printSlip');
$router->post('/tickets/{id}/cancel', 'TicketController@cancel', ['auth', 'csrf']);

// Approvals & Workflow
$router->get('/approvals', 'ApprovalController@index', ['auth']);
$router->post('/approvals/{id}/unit-approve', 'ApprovalController@approveUnit', ['auth', 'csrf']);
$router->post('/approvals/{id}/unit-reject', 'ApprovalController@rejectUnit', ['auth', 'csrf']);
$router->post('/approvals/{id}/ict-approve', 'ApprovalController@approveICT', ['auth', 'csrf']);
$router->post('/approvals/{id}/ict-reject', 'ApprovalController@rejectICT', ['auth', 'csrf']);
$router->post('/approvals/{id}/handover', 'ApprovalController@handover', ['auth', 'csrf']);
$router->post('/approvals/{id}/return', 'ApprovalController@returnAsset', ['auth', 'csrf']);

// Asset Inventory Management
$router->get('/assets', 'AssetController@index', ['auth']);
$router->get('/assets/create', 'AssetController@create', ['auth', 'admin']);
$router->post('/assets', 'AssetController@store', ['auth', 'admin', 'csrf']);
$router->get('/assets/{id}/edit', 'AssetController@edit', ['auth', 'admin']);
$router->post('/assets/{id}/update', 'AssetController@update', ['auth', 'admin', 'csrf']);
$router->post('/assets/{id}/delete', 'AssetController@delete', ['auth', 'admin', 'csrf']);

// Reports & Executive Analytics
$router->get('/reports', 'ReportController@index', ['auth']);
$router->get('/reports/export', 'ReportController@export', ['auth']);

// User Management (Admin Only Full CRUD) & Self Profile
$router->get('/users', 'UserController@index', ['auth', 'admin']);
$router->get('/users/create', 'UserController@create', ['auth', 'admin']);
$router->post('/users', 'UserController@store', ['auth', 'admin', 'csrf']);
$router->get('/users/{id}/edit', 'UserController@edit', ['auth', 'admin']);
$router->post('/users/{id}/update', 'UserController@update', ['auth', 'admin', 'csrf']);
$router->post('/users/{id}/delete', 'UserController@delete', ['auth', 'admin', 'csrf']);
$router->post('/users/{id}/toggle-status', 'UserController@toggleStatus', ['auth', 'admin', 'csrf']);
$router->post('/users/{id}/reset-password', 'UserController@resetPassword', ['auth', 'admin', 'csrf']);

// Master Data: Units & Positions Management (Admin Only)
$router->get('/units', 'UnitController@index', ['auth', 'admin']);
$router->get('/settings/units', function () { Response::redirect('/units'); }, ['auth', 'admin']);
$router->post('/settings/units/create', 'UnitController@createUnit', ['auth', 'admin', 'csrf']);
$router->get('/settings/units/{code}/update', function () { Response::redirect('/units'); }, ['auth', 'admin']);
$router->post('/settings/units/{code}/update', 'UnitController@updateUnit', ['auth', 'admin', 'csrf']);

$router->post('/settings/positions/create', 'UnitController@addPosition', ['auth', 'admin', 'csrf']);
$router->get('/settings/positions/{id}/update', function () { Response::redirect('/units'); }, ['auth', 'admin']);
$router->post('/settings/positions/{id}/update', 'UnitController@updatePosition', ['auth', 'admin', 'csrf']);
$router->post('/settings/positions/{id}/delete', 'UnitController@deletePosition', ['auth', 'admin', 'csrf']);

$router->get('/profile', 'UserController@profile', ['auth']);
$router->post('/profile', 'UserController@updateProfile', ['auth', 'csrf']);

// Dispatch Request
try {
    $router->dispatch();
} catch (\Throwable $e) {
    if (app_config('app.debug', false)) {
        echo "<pre style='background:#1e293b;color:#f87171;padding:20px;border-radius:8px;'>";
        echo "<b>Exception:</b> " . e($e->getMessage()) . "\n";
        echo "<b>File:</b> " . e($e->getFile()) . ":" . e((string)$e->getLine()) . "\n\n";
        echo "<b>Stack Trace:</b>\n" . e($e->getTraceAsString());
        echo "</pre>";
    } else {
        Response::abort(500, 'Berlaku ralat dalaman sistem. Sila hubungi Seksyen ICT BKP.');
    }
}
