<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

$isStatic = preg_match('/\.(?:css|js|mjs|map|png|jpe?g|gif|svg|webp|ico|woff2?|ttf|eot|otf|json|webmanifest|mp3|mp4|pdf)$/i', $uri);
if ($isStatic) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Not Found';
    return;
}

require_once __DIR__.'/public/index.php';
