<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise HTTP Request Handler
 */
class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $files;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
    }

    /**
     * Get HTTP Method
     */
    public function method(): string
    {
        $method = $this->server['REQUEST_METHOD'] ?? 'GET';
        if ($method === 'POST' && isset($this->post['_method'])) {
            $method = strtoupper((string) $this->post['_method']);
        }
        return strtoupper($method);
    }

    /**
     * Check if current request is POST
     */
    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    /**
     * Get Request URI path (normalized without query string and base subpaths)
     */
    public function uri(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Normalize multiple consecutive slashes
        $path = (string) preg_replace('#/+#', '/', $path);

        // Strip exact script name if present (e.g. /index.php/login)
        $scriptName = $this->server['SCRIPT_NAME'] ?? '';
        if ($scriptName && strpos($path, $scriptName) === 0) {
            $path = substr($path, strlen($scriptName));
        }

        // Strip dirname of script name (e.g. /helpdesk/public or /public or /helpdesk)
        $baseDir = dirname($scriptName);
        if ($baseDir !== '/' && $baseDir !== '\\' && $baseDir !== '.') {
            $baseDir = str_replace('\\', '/', $baseDir);
            if (strpos($path, $baseDir) === 0) {
                $path = substr($path, strlen($baseDir));
            }
        }

        // Handle Laragon virtual host / subfolder path redundancy where user accesses /helpdesk/public, /helpdesk, or /public
        foreach (['/helpdesk/public', '/helpdesk', '/public'] as $prefix) {
            if (strpos($path, $prefix) === 0) {
                $path = substr($path, strlen($prefix));
                break;
            }
        }

        $path = '/' . trim($path, '/');
        $path = (string) preg_replace('#/+#', '/', $path);
        return $path === '' ? '/' : $path;
    }

    /**
     * Retrieve input parameter from POST or GET
     */
    public function input(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->post)) {
            return $this->sanitize($this->post[$key]);
        }
        if (array_key_exists($key, $this->get)) {
            return $this->sanitize($this->get[$key]);
        }
        return $default;
    }

    /**
     * Retrieve raw input parameter without html stripping
     */
    public function raw(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    /**
     * Retrieve all input data
     */
    public function all(): array
    {
        $merged = array_merge($this->get, $this->post);
        return $this->sanitize($merged);
    }

    /**
     * Get subset of input data
     */
    public function only(array $keys): array
    {
        $all = $this->all();
        $result = [];
        foreach ($keys as $k) {
            $result[$k] = $all[$k] ?? null;
        }
        return $result;
    }

    /**
     * Check if request is AJAX / JSON
     */
    public function isAjax(): bool
    {
        return (!empty($this->server['HTTP_X_REQUESTED_WITH']) &&
            strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
            (isset($this->server['HTTP_ACCEPT']) && str_contains($this->server['HTTP_ACCEPT'], 'application/json'));
    }

    /**
     * Sanitize input recursively
     */
    private function sanitize(mixed $data): mixed
    {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $val) {
                $cleaned[$key] = $this->sanitize($val);
            }
            return $cleaned;
        }
        if (is_string($data)) {
            return trim($data);
        }
        return $data;
    }
}
