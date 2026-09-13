<?php
declare(strict_types=1);

abstract class BaseController
{
    protected function renderHtml(string $viewFile, array $viewData = []): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        extract($viewData);
        require $viewFile;
    }

    protected function renderJson(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}