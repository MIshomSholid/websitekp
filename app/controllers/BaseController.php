<?php
// app/controllers/BaseController.php

class BaseController
{
    protected function render(string $viewPath, array $data = []): void
    {
        // Extract variables for view scope
        extract($data);

        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';
        if (file_exists($fullPath)) {
            require $fullPath;
        } else {
            die("View not found: " . htmlspecialchars($viewPath));
        }
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
