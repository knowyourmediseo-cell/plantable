<?php
/**
 * Plantable Eco - Subdirectory Router
 * 
 * This file handles routing for the /plantable subdirectory on live server.
 * It rewrites all requests properly to the Laravel application.
 * 
 * .htaccess should rewrite /plantable/* to this file
 */

// Get the requested path, removing /plantable prefix
$requestedPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove /plantable/ from the beginning
if (strpos($requestedPath, '/plantable') === 0) {
    $requestedPath = substr($requestedPath, 9); // Remove /plantable (9 characters)
}

// Ensure it starts with /
if (empty($requestedPath)) {
    $requestedPath = '/';
}

// Update $_SERVER variables for Laravel
$_SERVER['REQUEST_URI'] = $requestedPath;
$_SERVER['PHP_SELF'] = $requestedPath;

// Now route to the actual index.php
require __DIR__ . '/index.php';
