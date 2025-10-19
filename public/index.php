<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

$request = Request::capture();

try {
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e) {
    // Handle MethodNotAllowed errors gracefully
    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed");
    echo "Method Not Allowed. Supported methods: " . implode(', ', $e->getHeaders()['Allow'] ?? []);
    exit;
} catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
    // Handle 404 errors gracefully
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo "Page not found.";
    exit;
} catch (\Exception $e) {
    // Handle any other exceptions
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    echo "An unexpected error occurred: " . $e->getMessage();
    exit;
}
