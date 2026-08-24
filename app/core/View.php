<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise View & Template Renderer
 */
class View
{
    private static string $viewsPath;

    public static function init(): void
    {
        self::$viewsPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }

    /**
     * Render a view with an optional layout
     */
    public static function render(string $template, array $data = [], ?string $layout = 'app'): void
    {
        self::init();

        $templateFile = self::$viewsPath . str_replace(['.', '/'], DIRECTORY_SEPARATOR, $template) . '.php';

        if (!file_exists($templateFile)) {
            throw new \RuntimeException("Fail paparan view tidak dijumpai: {$templateFile}");
        }

        // Extract variables into view scope
        extract($data, EXTR_SKIP);

        // Capture inner view content
        ob_start();
        require $templateFile;
        $content = ob_get_clean();

        if ($layout === null) {
            echo $content;
            return;
        }

        $layoutFile = self::$viewsPath . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Fail layout tidak dijumpai: {$layoutFile}");
        }

        // Render layout with inner content
        require $layoutFile;
    }

    /**
     * Render a partial component directly
     */
    public static function partial(string $partial, array $data = []): void
    {
        self::init();
        $partialFile = self::$viewsPath . 'partials' . DIRECTORY_SEPARATOR . str_replace(['.', '/'], DIRECTORY_SEPARATOR, $partial) . '.php';

        if (!file_exists($partialFile)) {
            // Also check root views folder if not in partials
            $partialFile = self::$viewsPath . str_replace(['.', '/'], DIRECTORY_SEPARATOR, $partial) . '.php';
        }

        if (file_exists($partialFile)) {
            extract($data, EXTR_SKIP);
            require $partialFile;
        } else {
            echo "<!-- Partial [{$partial}] not found -->";
        }
    }
}
