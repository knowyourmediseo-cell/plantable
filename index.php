<?php
/**
 * PLANTABLE ECO - ROOT ROUTER (SIMPLIFIED)
 * 
 * This file handles all requests to /plantable/* subdirectory
 * Routes them to Laravel's public/index.php
 * 
 * Note: The .htaccess file rewrites to public/index.php
 * This file is here as a fallback if .htaccess doesn't work
 */

$base_path = __DIR__;
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';

// If requesting something in /plantable/, route to public/index.php
if (strpos($request_uri, '/plantable') === 0) {
    // Let .htaccess handle it by routing to public/index.php
    // But if we're here, we need to do it manually
    
    // Extract the path after /plantable
    $path = substr($request_uri, 10); // Remove '/plantable'
    if (empty($path)) {
        $path = '/';
    }
    
    // Check if it's a static file in public
    $file_path = $base_path . '/public' . $path;
    if (file_exists($file_path) && is_file($file_path)) {
        // Serve static file directly
        $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $mime_map = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
        ];
        
        if (isset($mime_map[$ext])) {
            header('Content-Type: ' . $mime_map[$ext]);
        }
        
        // Set cache headers for static assets
        if (strpos($file_path, '/build/') !== false) {
            header('Cache-Control: public, max-age=31536000, immutable');
        }
        
        readfile($file_path);
        exit;
    }
    
    // Not a static file, route to Laravel
    // Update REQUEST_URI to remove /plantable prefix
    $_SERVER['REQUEST_URI'] = $path;
    $_SERVER['PATH_INFO'] = $path;
    
    require $base_path . '/public/index.php';
} else {
    // Not a /plantable request, might be direct to /public
    require $base_path . '/public/index.php';
}

