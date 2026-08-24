<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise Router Engine
 */
class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Register a GET route
     */
    public function get(string $path, string|array|callable $handler, array $middlewares = []): self
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
        return $this;
    }

    /**
     * Register a POST route
     */
    public function post(string $path, string|array|callable $handler, array $middlewares = []): self
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
        return $this;
    }

    /**
     * Internal route registrar
     */
    private function addRoute(string $method, string $path, string|array|callable $handler, array $middlewares): void
    {
        $path = '/' . trim($path, '/');
        if ($path === '') {
            $path = '/';
        }

        // Convert {param} to regex pattern
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $regex = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'regex' => $regex,
            'handler' => $handler,
            'middlewares' => $middlewares,
        ];
    }

    /**
     * Register custom named middleware
     */
    public function registerMiddleware(string $name, callable $handler): void
    {
        $this->middlewares[$name] = $handler;
    }

    /**
     * Dispatch the current HTTP request
     */
    public function dispatch(): void
    {
        $requestMethod = $this->request->method();
        $requestUri = $this->request->uri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($route['regex'], $requestUri, $matches)) {
                // Filter named route arguments
                $params = array_filter($matches, function ($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                // Run route middlewares
                $this->runMiddlewares($route['middlewares']);

                // Execute handler
                $this->executeHandler($route['handler'], $params);
                return;
            }
        }

        // No route matched -> 404
        Response::abort(404, 'Halaman atau tindakan yang diminta tidak wujud.');
    }

    /**
     * Run configured middlewares
     */
    private function runMiddlewares(array $middlewareNames): void
    {
        foreach ($middlewareNames as $mw) {
            if ($mw === 'auth') {
                if (!Auth::check()) {
                    Session::flash('error', 'Sila log masuk terlebih dahulu untuk mengakses sistem.');
                    Response::redirect('/login');
                }
            } elseif ($mw === 'guest') {
                if (Auth::check()) {
                    Response::redirect('/dashboard');
                }
            } elseif ($mw === 'admin') {
                if (!Auth::isAdmin()) {
                    Session::flash('error', 'Akses dinafikan. Anda tidak mempunyai kebenaran pentadbir.');
                    Response::redirect('/dashboard');
                }
            } elseif ($mw === 'csrf') {
                if ($this->request->isPost()) {
                    $token = $this->request->input('_csrf_token');
                    if (!Session::validateCsrf($token)) {
                        Session::flash('error', 'Sesi borang telah tamat. Sila cuba lagi.');
                        Response::redirect($this->request->uri());
                    }
                }
            } elseif (isset($this->middlewares[$mw])) {
                call_user_func($this->middlewares[$mw], $this->request);
            }
        }
    }

    /**
     * Execute Controller@action or callable
     */
    private function executeHandler(string|array|callable $handler, array $params): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, [$this->request, ...$params]);
            return;
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$class, $method] = explode('@', $handler);
            if (!str_starts_with($class, 'App\\Controllers\\')) {
                $class = 'App\\Controllers\\' . $class;
            }

            if (!class_exists($class)) {
                throw new \RuntimeException("Controller class '{$class}' tidak ditemui.");
            }

            $instance = new $class();
            if (!method_exists($instance, $method)) {
                throw new \RuntimeException("Kaedah '{$method}' tidak wujud dalam '{$class}'.");
            }

            call_user_func_array([$instance, $method], [$this->request, ...$params]);
            return;
        }

        throw new \InvalidArgumentException("Format pengendali laluan tidak sah.");
    }
}
