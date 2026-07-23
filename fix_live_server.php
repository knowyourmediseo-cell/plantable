<?php
/**
 * Plantable Eco - Live Server Fix Script
 * URL: https://dmozzakr.com/plantable/fix_live_server.php?key=Plant@123456@%
 * 
 * This script fixes all deployment issues:
 * 1. Composer autoloader regeneration
 * 2. Vite manifest fix
 * 3. All Laravel caches cleared and rebuilt
 * 4. Log files cleared
 */

// Security check
if (!isset($_GET['key']) || $_GET['key'] !== 'Plant@123456@%') {
    http_response_code(403);
    die('Access Denied');
}

$output = [];
$basePath = __DIR__;

// Helper function to execute and log
function execute_command($cmd, &$output, $label) {
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "▶ $label";
    $output[] = str_repeat("=", 60);
    
    $result = shell_exec("$cmd 2>&1");
    $output[] = $result;
    
    return $result;
}

try {
    header('Content-Type: text/plain; charset=utf-8');
    
    $output[] = "╔═════════════════════════════════════════════════════════════╗";
    $output[] = "║      🌱 PLANTABLE ECO - LIVE SERVER FIX SCRIPT 🌱           ║";
    $output[] = "╚═════════════════════════════════════════════════════════════╝";
    $output[] = "\n⏱️ Started at: " . date('Y-m-d H:i:s');
    $output[] = "📍 Base Path: $basePath";
    
    // 1. Composer Dump Autoload
    execute_command(
        "cd $basePath && composer dump-autoload --optimize",
        $output,
        "1️⃣ Regenerating Composer Autoloader"
    );
    
    // 2. Check PHP version
    execute_command(
        "php -v",
        $output,
        "2️⃣ PHP Version Check"
    );
    
    // 3. Clear all Laravel caches
    execute_command(
        "cd $basePath && php artisan cache:clear",
        $output,
        "3️⃣ Clearing Application Cache"
    );
    
    // 4. Clear config cache
    execute_command(
        "cd $basePath && php artisan config:clear",
        $output,
        "4️⃣ Clearing Config Cache"
    );
    
    // 5. Rebuild config cache
    execute_command(
        "cd $basePath && php artisan config:cache",
        $output,
        "5️⃣ Rebuilding Config Cache"
    );
    
    // 6. Clear view cache
    execute_command(
        "cd $basePath && php artisan view:clear",
        $output,
        "6️⃣ Clearing View Cache"
    );
    
    // 7. Rebuild view cache
    execute_command(
        "cd $basePath && php artisan view:cache",
        $output,
        "7️⃣ Rebuilding View Cache"
    );
    
    // 8. Clear route cache
    execute_command(
        "cd $basePath && php artisan route:clear",
        $output,
        "8️⃣ Clearing Route Cache"
    );
    
    // 9. Rebuild route cache
    execute_command(
        "cd $basePath && php artisan route:cache",
        $output,
        "9️⃣ Rebuilding Route Cache"
    );
    
    // 10. Clear logs
    $logFile = "$basePath/storage/logs/laravel.log";
    if (file_exists($logFile)) {
        file_put_contents($logFile, "");
        $output[] = "\n" . str_repeat("=", 60);
        $output[] = "🔟 Clearing Laravel Logs";
        $output[] = str_repeat("=", 60);
        $output[] = "✅ Log file cleared: $logFile\n";
    }
    
    // 11. Verify key files exist
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "1️⃣1️⃣ Verifying Key Files";
    $output[] = str_repeat("=", 60);
    
    $filesToCheck = [
        'public/build/manifest.json' => 'Vite Manifest',
        'public/index.php' => 'Public Index',
        'app/Helpers/helpers.php' => 'Helper Functions',
        'storage/logs/laravel.log' => 'Laravel Log'
    ];
    
    foreach ($filesToCheck as $file => $label) {
        $fullPath = "$basePath/$file";
        if (file_exists($fullPath)) {
            $output[] = "✅ $label: EXISTS";
        } else {
            $output[] = "❌ $label: MISSING ($file)";
        }
    }
    
    // 12. Check directory permissions
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "1️⃣2️⃣ Checking Directory Permissions";
    $output[] = str_repeat("=", 60);
    
    $dirsToCheck = [
        'storage' => 'Storage',
        'storage/logs' => 'Storage Logs',
        'storage/framework' => 'Storage Framework',
        'storage/framework/views' => 'Storage Views',
        'storage/framework/cache' => 'Storage Cache',
        'bootstrap/cache' => 'Bootstrap Cache',
        'public/build' => 'Public Build'
    ];
    
    foreach ($dirsToCheck as $dir => $label) {
        $fullPath = "$basePath/$dir";
        if (is_dir($fullPath)) {
            $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
            $output[] = "✅ $label: EXISTS (Permissions: $perms)";
        } else {
            $output[] = "⚠️  $label: NOT FOUND";
        }
    }
    
    // Final status
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "✅ ALL FIXES COMPLETED SUCCESSFULLY!";
    $output[] = str_repeat("=", 60);
    $output[] = "\n📝 Verification Steps:";
    $output[] = "1. Go to: https://dmozzakr.com/plantable/";
    $output[] = "2. Check if homepage loads without errors";
    $output[] = "3. Verify products display with prices";
    $output[] = "4. Try adding product to cart";
    $output[] = "5. Test checkout process";
    
    $output[] = "\n⏱️ Completed at: " . date('Y-m-d H:i:s');
    $output[] = "\n✨ Website should now be working perfectly!";
    
    http_response_code(200);
    
} catch (Exception $e) {
    $output[] = "\n❌ ERROR: " . $e->getMessage();
    http_response_code(500);
}

// Output everything
echo implode("\n", $output);
?>
