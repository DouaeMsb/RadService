<?php
declare(strict_types=1);

class Router
{
    public function getRoute(): array
    {
        $route = trim((string)($_GET['url'] ?? ''), '/');
        $routeParts = explode('/', $route);

        return [
            'base' => $routeParts[0] ?? '',
            'resource' => $routeParts[1] ?? null,
            'parameter' => $routeParts[2] ?? null
        ];
    }

    public static function generateUrl(string $path = ''): string
    {
        $base = rtrim(str_replace('\\', '/', dirname((string)$_SERVER['SCRIPT_NAME'])), '/');
        $path = ltrim($path, '/');
        return $path === '' ? $base . '/' : $base . '/' . $path;
    }
}