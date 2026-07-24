<?php
/**
 * PLANTABLE ECO - ROOT ROUTER
 * 
 * This file handles all requests to /plantable/* subdirectory
 * and routes them properly to Laravel's public/index.php
 */

// Get the request path
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove /plantable prefix
if (strpos($request_path, '/plantable/') === 0) {
    $request_path = substr($request_path, strlen('/plantable'));
} elseif (strpos($request_path, '/plantable') === 0) {
    $request_path = substr($request_path, strlen('/plantable'));
}

// Ensure path starts with /
if (empty($request_path) || $request_path === '') {
    $request_path = '/';
}

// Check if it's a static file in public folder
$public_path = __DIR__ . '/public' . $request_path;

// Handle static files
if (file_exists($public_path) && is_file($public_path)) {
    // Determine MIME type
    $ext = pathinfo($public_path, PATHINFO_EXTENSION);
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
        'eot' => 'application/vnd.ms-fontobject',
        'json' => 'application/json',
        'txt' => 'text/plain',
        'html' => 'text/html',
        'pdf' => 'application/pdf'
    ];
    
    $mime = $mime_types[$ext] ?? 'application/octet-stream';
    header('Content-Type: ' . $mime);
    readfile($public_path);
    exit;
}

// Update $_SERVER for Laravel
$_SERVER['REQUEST_URI'] = $request_path;
$_SERVER['PATH_INFO'] = $request_path;

// Route to Laravel's public/index.php
require __DIR__ . '/public/index.php';
