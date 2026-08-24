<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise Session & Flash Data Handler
 */
class Session
{
    private static bool $started = false;
    private static array $cliSession = [];

    /**
     * Start session safely if not already active
     */
    public static function start(): void
    {
        if (self::$started || session_status() === PHP_SESSION_ACTIVE) {
            self::$started = true;
            return;
        }

        if (php_sapi_name() === 'cli') {
            self::$started = true;
            if (!isset(self::$cliSession['_flash'])) {
                self::$cliSession['_flash'] = ['new' => [], 'old' => []];
            }
            return;
        }

        if (!headers_sent()) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_only_cookies', '1');
            ini_set('session.cookie_samesite', 'Lax');

            session_name('ICTBKP_SESSID');
            session_start();
        }

        self::$started = true;

        // Initialize flash storage
        if (!isset($_SESSION['_flash'])) {
            $_SESSION['_flash'] = [
                'new' => [],
                'old' => [],
            ];
        } else {
            // Age existing flashes
            $_SESSION['_flash']['old'] = $_SESSION['_flash']['new'] ?? [];
            $_SESSION['_flash']['new'] = [];
        }
    }

    /**
     * Get a session value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            return self::$cliSession[$key] ?? $default;
        }
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set a session value
     */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            self::$cliSession[$key] = $value;
            return;
        }
        $_SESSION[$key] = $value;
    }

    /**
     * Check if a session key exists
     */
    public static function has(string $key): bool
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            return isset(self::$cliSession[$key]);
        }
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a key from session
     */
    public static function remove(string $key): void
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            unset(self::$cliSession[$key]);
            return;
        }
        unset($_SESSION[$key]);
    }

    /**
     * Clear all session data
     */
    public static function destroy(): void
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            self::$cliSession = [];
            self::$started = false;
            return;
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies") && !headers_sent()) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        self::$started = false;
    }

    /**
     * Set a flash message for the next request
     */
    public static function flash(string $type, string $message): void
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            self::$cliSession['_flash']['new'][$type] = $message;
            return;
        }
        $_SESSION['_flash']['new'][$type] = $message;
    }

    /**
     * Get flash message by type
     */
    public static function getFlash(string $type, ?string $default = null): ?string
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            return self::$cliSession['_flash']['old'][$type] ?? self::$cliSession['_flash']['new'][$type] ?? $default;
        }
        return $_SESSION['_flash']['old'][$type] ?? $_SESSION['_flash']['new'][$type] ?? $default;
    }

    /**
     * Flash old form inputs for repopulation
     */
    public static function flashInput(array $data): void
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            self::$cliSession['_old_input'] = $data;
            return;
        }
        $_SESSION['_old_input'] = $data;
    }

    /**
     * Get old input value
     */
    public static function getOldInput(string $key, mixed $default = ''): mixed
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            return self::$cliSession['_old_input'][$key] ?? $default;
        }
        return $_SESSION['_old_input'][$key] ?? $default;
    }

    /**
     * Clear old inputs
     */
    public static function clearOldInput(): void
    {
        self::start();
        if (php_sapi_name() === 'cli') {
            unset(self::$cliSession['_old_input']);
            return;
        }
        unset($_SESSION['_old_input']);
    }

    /**
     * Generate or return existing CSRF token
     */
    public static function csrfToken(): string
    {
        self::start();
        $token = self::get('_csrf_token');
        if (empty($token)) {
            $token = bin2hex(random_bytes(32));
            self::set('_csrf_token', $token);
        }
        return $token;
    }

    /**
     * Validate submitted CSRF token
     */
    public static function validateCsrf(?string $token): bool
    {
        self::start();
        $stored = self::get('_csrf_token', '');
        if (empty($stored) || empty($token)) {
            return false;
        }
        return hash_equals($stored, $token);
    }
}
