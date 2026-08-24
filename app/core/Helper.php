<?php
declare(strict_types=1);

use App\Core\Auth;
use App\Core\Session;
use App\Repositories\UnitRepository;
use App\Repositories\PositionRepository;

/**
 * Enterprise Global Helper Functions
 * Project: Helpdesk ICTBKP
 */

if (!function_exists('app_config')) {
    /**
     * Retrieve configuration value by dot-notated key
     * Dynamically resolves units and positions from storage engine if available
     */
    function app_config(string $key, mixed $default = null): mixed
    {
        static $configs = [];
        $parts = explode('.', $key);
        $file = array_shift($parts);

        // Dynamic resolution for units
        if ($file === 'units' && class_exists(UnitRepository::class)) {
            try {
                $unitRepo = new UnitRepository();
                $unitsData = $unitRepo->getAllKeyed();
                if (!empty($unitsData)) {
                    $configs['units'] = $unitsData;
                }
            } catch (\Throwable $e) {
                // fallback to static file
            }
        }

        // Dynamic resolution for positions
        if ($file === 'positions' && class_exists(PositionRepository::class)) {
            try {
                $posRepo = new PositionRepository();
                $titles = $posRepo->getActiveTitles();
                if (!empty($titles)) {
                    $configs['positions'] = ['standard_positions' => $titles];
                }
            } catch (\Throwable $e) {
                // fallback to static file
            }
        }

        if (!isset($configs[$file])) {
            $configPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file . '.php';
            if (file_exists($configPath)) {
                $configs[$file] = require $configPath;
            } else {
                $configs[$file] = [];
            }
        }

        $current = $configs[$file];
        foreach ($parts as $segment) {
            if (is_array($current) && array_key_exists($segment, $current)) {
                $current = $current[$segment];
            } else {
                return $default;
            }
        }

        return $current;
    }
}

if (!function_exists('app_base_url')) {
    /**
     * Dynamically detect base URL prefix from current HTTP request
     */
    function app_base_url(): string
    {
        $server = $_SERVER;
        $requestUri = $server['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';

        if (str_starts_with($path, '/helpdesk/public')) {
            return '/helpdesk/public';
        }
        if (str_starts_with($path, '/helpdesk')) {
            return '/helpdesk';
        }
        if (str_starts_with($path, '/public')) {
            return '/public';
        }

        return '';
    }
}

if (!function_exists('url')) {
    /**
     * Generate application URL relative to the active base environment
     */
    function url(string $path = ''): string
    {
        $baseUrl = app_base_url();
        $path = ltrim($path, '/');
        if ($path === '') {
            return $baseUrl === '' ? '/' : $baseUrl;
        }
        return ($baseUrl === '' ? '' : $baseUrl) . '/' . $path;
    }
}

if (!function_exists('asset')) {
    /**
     * Generate URL for public asset
     */
    function asset(string $path): string
    {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('e')) {
    /**
     * HTML entity encode string
     */
    function e(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get or generate current CSRF token
     */
    function csrf_token(): string
    {
        return Session::csrfToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate hidden HTML CSRF input field
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_csrf_token" value="' . e(csrf_token()) . '">';
    }
}

if (!function_exists('old')) {
    /**
     * Retrieve flashed old input value
     */
    function old(string $key, mixed $default = ''): mixed
    {
        return Session::getOldInput($key, $default);
    }
}

if (!function_exists('current_user')) {
    /**
     * Get currently logged-in user array
     */
    function current_user(): ?array
    {
        return Auth::user();
    }
}

if (!function_exists('auth_check')) {
    /**
     * Check if user is logged in
     */
    function auth_check(): bool
    {
        return Auth::check();
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date string to Malaysian standard (e.g. 23 Ogos 2026)
     */
    function format_date(?string $dateStr, string $format = 'd M Y'): string
    {
        if (empty($dateStr)) {
            return '-';
        }
        try {
            $dt = new \DateTime($dateStr, new \DateTimeZone(app_config('app.timezone', 'Asia/Kuala_Lumpur')));
            $months = [
                'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mac', 'Apr' => 'Apr',
                'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ogos',
                'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Dis',
            ];
            $formatted = $dt->format($format);
            return strtr($formatted, $months);
        } catch (\Exception $e) {
            return $dateStr;
        }
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format date and time
     */
    function format_datetime(?string $dateStr): string
    {
        if (empty($dateStr)) {
            return '-';
        }
        return format_date($dateStr, 'd M Y, h:i A');
    }
}
