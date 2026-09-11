<?php
declare(strict_types=1);
require_once 'App/Core/Router.php';

$router = new Router();
$route = $router->getRoute();

try {
    switch ($route['base']) {
        case 'home':
            require_once 'App/View/home.php';
            exit;

        default:
            http_response_code(404);
            echo '<h1>404 - Page not found</h1>';
            exit;
    }
} catch (Exception $e) {
    header('Content-type: text/html; charset=UTF-8');
    echo '<h1>Unexpected error occurred</h1>';
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}