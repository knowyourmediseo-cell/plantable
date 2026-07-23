<?php
/**
 * Plantable Eco - Complete Subdirectory Router
 * 
 * This file handles ALL requests for /plantable/* subdirectory.
 * It properly rewrites paths, loads assets, and routes to Laravel.
 * 
 * This replaces the need for complex .htaccess configurations.
 * All requests to /plantable/* should be handled by this file or the web server.
 */

// Get the full request path
$request_path = $_SERVER['REQUEST_URI'];

// Remove /plantable/ prefix to get internal path
if (strpos($request_path, '/plantable/') === 0) {
    $clean_path = substr($request_path, strlen('/plantable'));
} else {
    $clean_path = $request_path;
}

// Remove query string from path
if (strpos($clean_path, '?') !== false) {
    $clean_path = substr($clean_path, 0, strpos($clean_path, '?'));
}

// Static files - serve directly from public
$static_extensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico', 'woff', 'woff2', 'ttf', 'eot'];

$file_extension = '';
if (strpos($clean_path, '.') !== false) {
    $parts = explode('.', $clean_path);
    $file_extension = strtolower(end($parts));
}

// If it's a static file, serve it
if (in_array($file_extension, $static_extensions)) {
    $file_path = __DIR__ . $clean_path;
    if (file_exists($file_path) && is_file($file_path)) {
        // Serve the file with correct headers
        $mime_types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject'
        ];
        
        header('Content-Type: ' . ($mime_types[$file_extension] ?? 'application/octet-stream'));
        readfile($file_path);
        exit;
    }
}

// For everything else, route through Laravel
$_SERVER['REQUEST_URI'] = $clean_path ?: '/';
$_SERVER['PATH_INFO'] = $clean_path ?: '/';

// Include Laravel's index.php
require __DIR__ . '/index.php';

