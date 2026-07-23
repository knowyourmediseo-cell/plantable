<?php
/**
 * This script fixes the live deployment issues
 * Access via: https://dmozzakr.com/plantable/fix_live.php?key=Plant@123456@%
 */

// Security check
if (!isset($_GET['key']) || $_GET['key'] !== 'Plant@123456@%') {
    http_response_code(403);
    die('Forbidden');
}

$output = [];
$basePath = __DIR__;

try {
    // 1. Dump autoloader
    $output[] = "=== Dumping Composer Autoloader ===";
    exec("cd {$basePath} && composer dump-autoload --optimize 2>&1", $composerOutput);
    $output = array_merge($output, $composerOutput);

    // 2. Clear config cache
    $output[] = "\n=== Clearing Config Cache ===";
    exec("cd {$basePath} && php artisan config:clear 2>&1", $configOutput);
    $output = array_merge($output, $configOutput);

    // 3. Cache config again
    $output[] = "\n=== Caching Config ===";
    exec("cd {$basePath} && php artisan config:cache 2>&1", $cacheConfigOutput);
    $output = array_merge($output, $cacheConfigOutput);

    // 4. Clear view cache
    $output[] = "\n=== Clearing View Cache ===";
    exec("cd {$basePath} && php artisan view:clear 2>&1", $viewClearOutput);
    $output = array_merge($output, $viewClearOutput);

    // 5. Cache views
    $output[] = "\n=== Caching Views ===";
    exec("cd {$basePath} && php artisan view:cache 2>&1", $viewCacheOutput);
    $output = array_merge($output, $viewCacheOutput);

    // 6. Clear route cache
    $output[] = "\n=== Clearing Route Cache ===";
    exec("cd {$basePath} && php artisan route:clear 2>&1", $routeClearOutput);
    $output = array_merge($output, $routeClearOutput);

    // 7. Cache routes
    $output[] = "\n=== Caching Routes ===";
    exec("cd {$basePath} && php artisan route:cache 2>&1", $routeCacheOutput);
    $output = array_merge($output, $routeCacheOutput);

    // 8. Clear all caches
    $output[] = "\n=== Clearing All Caches ===";
    exec("cd {$basePath} && php artisan cache:clear 2>&1", $cacheClearOutput);
    $output = array_merge($output, $cacheClearOutput);

    $output[] = "\n✅ All fixes completed successfully!";
    $statusCode = 200;
} catch (Exception $e) {
    $output[] = "❌ Error: " . $e->getMessage();
    $statusCode = 500;
}

header('Content-Type: text/plain');
http_response_code($statusCode);
echo implode("\n", $output);
?>
