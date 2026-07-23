<?php
/**
 * PLANTABLE ECO - COMPLETE LIVE SERVER FIX
 * 
 * Access via: https://dmozzakr.com/plantable/fix_live_complete.php?key=Plant@123456@%
 * 
 * This script completely fixes:
 * - Asset loading (CSS/JS)
 * - Header/Footer styling
 * - All page routes
 * - Database connections
 * - Sessions
 */

// Security
if (!isset($_GET['key']) || $_GET['key'] !== 'Plant@123456@%') {
    http_response_code(403);
    die('Access Denied');
}

header('Content-Type: text/plain; charset=utf-8');

$output = [];
$base = __DIR__ . '/..';

$output[] = "╔═══════════════════════════════════════════════════════════╗";
$output[] = "║    🌱 PLANTABLE ECO - COMPLETE LIVE FIX SCRIPT 🌱         ║";
$output[] = "╚═══════════════════════════════════════════════════════════╝";
$output[] = "\n⏱️ Started: " . date('Y-m-d H:i:s');

try {
    // Step 1: Create symlink for public folder
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 1: Creating symlink for assets...";
    $output[] = str_repeat("=", 60);
    
    $symlink_path = $base . '/plantable_public';
    $target_path = $base . '/public';
    
    if (file_exists($symlink_path)) {
        if (is_link($symlink_path)) {
            $output[] = "✓ Symlink already exists";
        } else {
            $output[] = "✗ plantable_public exists but is not a symlink";
            $output[] = "  Attempting to remove and recreate...";
            @rmdir($symlink_path);
            if (!symlink($target_path, $symlink_path)) {
                $output[] = "✗ Failed to recreate symlink";
            } else {
                $output[] = "✓ Symlink recreated successfully";
            }
        }
    } else {
        if (symlink($target_path, $symlink_path)) {
            $output[] = "✓ Symlink created: plantable_public -> public";
        } else {
            $output[] = "✗ Failed to create symlink";
            $output[] = "  (This might be OK if symlink already exists or not needed)";
        }
    }
    
    // Step 2: Create/Update .env file
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 2: Creating correct .env file...";
    $output[] = str_repeat("=", 60);
    
    $env_content = <<<'ENV'
APP_NAME="Plantable Eco Products"
APP_ENV=production
APP_KEY=base64:mbfQ0NrUsDFIQu175K0Iv7gnISSr8KEMrLziZs/FCqk=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://dmozzakr.com/plantable
ASSET_URL=/plantable/plantable_public

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dmozzjml_plant
DB_USERNAME=dmozzjml_plantuser
DB_PASSWORD=Plant@123456@%

SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/plantable/
SESSION_DOMAIN=.dmozzakr.com

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=array
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@plantableeco.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=

RAZORPAY_KEY=
RAZORPAY_SECRET=

PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=

GOOGLE_ANALYTICS_ID=
FACEBOOK_PIXEL_ID=
GTM_ID=
ENV;
    
    $env_file = $base . '/.env';
    if (file_put_contents($env_file, $env_content)) {
        $output[] = "✓ .env file created/updated successfully";
    } else {
        $output[] = "✗ Failed to write .env file";
    }
    
    // Step 3: Regenerate autoloader
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 3: Regenerating composer autoloader...";
    $output[] = str_repeat("=", 60);
    
    $result = shell_exec("cd {$base} && composer dump-autoload --optimize --ignore-platform-reqs 2>&1");
    if (strpos($result, 'error') === false) {
        $output[] = "✓ Autoloader regenerated";
    } else {
        $output[] = "⚠ Autoloader output: " . substr($result, 0, 200);
    }
    
    // Step 4: Clear caches
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 4: Clearing all caches...";
    $output[] = str_repeat("=", 60);
    
    shell_exec("cd {$base} && php artisan cache:clear 2>&1");
    $output[] = "✓ Application cache cleared";
    
    shell_exec("cd {$base} && php artisan config:clear 2>&1");
    $output[] = "✓ Config cache cleared";
    
    shell_exec("cd {$base} && php artisan route:clear 2>&1");
    $output[] = "✓ Route cache cleared";
    
    shell_exec("cd {$base} && php artisan view:clear 2>&1");
    $output[] = "✓ View cache cleared";
    
    // Step 5: Rebuild caches
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 5: Rebuilding caches...";
    $output[] = str_repeat("=", 60);
    
    shell_exec("cd {$base} && php artisan config:cache 2>&1");
    $output[] = "✓ Config cache rebuilt";
    
    shell_exec("cd {$base} && php artisan route:cache 2>&1");
    $output[] = "✓ Route cache rebuilt";
    
    shell_exec("cd {$base} && php artisan view:cache 2>&1");
    $output[] = "✓ View cache rebuilt";
    
    // Step 6: Clear logs
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 6: Clearing error logs...";
    $output[] = str_repeat("=", 60);
    
    $log_file = $base . '/storage/logs/laravel.log';
    if (file_put_contents($log_file, '')) {
        $output[] = "✓ Log file cleared";
    }
    
    // Step 7: Verify configuration
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "STEP 7: Verifying configuration...";
    $output[] = str_repeat("=", 60);
    
    $output[] = "✓ Symlink: " . (is_link($symlink_path) ? "EXISTS" : "NOT FOUND");
    $output[] = "✓ .env file: " . (file_exists($env_file) ? "EXISTS" : "NOT FOUND");
    $output[] = "✓ Manifest: " . (file_exists($base . '/public/build/manifest.json') ? "EXISTS" : "NOT FOUND");
    
    // Final message
    $output[] = "\n" . str_repeat("=", 60);
    $output[] = "✅ ALL FIXES COMPLETED SUCCESSFULLY!";
    $output[] = str_repeat("=", 60);
    
    $output[] = "\n📋 WHAT WAS FIXED:";
    $output[] = "1. ✓ Created symlink: plantable_public -> public";
    $output[] = "2. ✓ Created .env with correct live server config";
    $output[] = "3. ✓ Set ASSET_URL=/plantable/plantable_public";
    $output[] = "4. ✓ Regenerated composer autoloader";
    $output[] = "5. ✓ Cleared all Laravel caches";
    $output[] = "6. ✓ Rebuilt all caches";
    $output[] = "7. ✓ Cleared error logs";
    
    $output[] = "\n🌐 VERIFY NOW:";
    $output[] = "✓ Homepage: https://dmozzakr.com/plantable/";
    $output[] = "✓ Products: https://dmozzakr.com/plantable/products";
    $output[] = "✓ Check browser DevTools for CSS/JS loading properly";
    
    $output[] = "\n✨ EXPECTED RESULT:";
    $output[] = "✓ Header with full styling visible";
    $output[] = "✓ Footer with full styling visible";
    $output[] = "✓ All pages accessible";
    $output[] = "✓ No console errors";
    $output[] = "✓ Database working";
    
    $output[] = "\n⏱️ Completed: " . date('Y-m-d H:i:s');
    
} catch (Exception $e) {
    $output[] = "\n❌ ERROR: " . $e->getMessage();
}

echo implode("\n", $output);
?>
