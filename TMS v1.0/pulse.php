<?php
// pulse.php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve real files as-is (css, js, images, etc.)
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// If a .php file exists matching the path, include it
$phpFile = __DIR__ . $uri . '.php';
if (file_exists($phpFile)) {
    require $phpFile;
    return true;
}

// Fallback to index.php for normal page routes (optional)
if ($uri === '/' && file_exists(__DIR__ . '/index.php')) {
    require __DIR__ . '/index.php';
    return true;
}

// Nothing matched — go to custom 404 handler
require __DIR__ . '/not-found/index.php';
return true;