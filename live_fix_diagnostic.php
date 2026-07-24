<?php
/**
 * LIVE SERVER DIAGNOSTIC & FIX SCRIPT
 * Run this on the live server: php ~/public_html/plantable/live_fix_diagnostic.php
 */

echo "=== PLANTABLE ECO LIVE SERVER DIAGNOSTIC ===\n\n";

$base_path = __DIR__;
$env_file = $base_path . '/.env';

// 1. Check .env file exists
echo "1. Checking .env file...\n";
if (!file_exists($env_file)) {
    echo "❌ .env file NOT found at: $env_file\n";
    exit(1);
}
echo "✅ .env file exists\n\n";

// 2. Read .env and check database password
echo "2. Checking database configuration in .env...\n";
$env_content = file_get_contents($env_file);

preg_match('/DB_PASSWORD=(.*)/', $env_content, $db_pass_match);
$current_password = isset($db_pass_match[1]) ? trim($db_pass_match[1]) : 'NOT SET';

preg_match('/DB_HOST=(.*)/', $env_content, $db_host_match);
$db_host = isset($db_host_match[1]) ? trim($db_host_match[1]) : 'NOT SET';

preg_match('/DB_DATABASE=(.*)/', $env_content, $db_name_match);
$db_name = isset($db_name_match[1]) ? trim($db_name_match[1]) : 'NOT SET';

preg_match('/DB_USERNAME=(.*)/', $env_content, $db_user_match);
$db_user = isset($db_user_match[1]) ? trim($db_user_match[1]) : 'NOT SET';

echo "DB_HOST: $db_host\n";
echo "DB_DATABASE: $db_name\n";
echo "DB_USERNAME: $db_user\n";
echo "DB_PASSWORD: " . (strlen($current_password) > 0 ? "SET (length: " . strlen($current_password) . ")" : "EMPTY") . "\n";

$correct_password = 'Plant@123456@%';
if ($current_password !== $correct_password) {
    echo "❌ DATABASE PASSWORD IS INCORRECT\n";
    echo "   Expected: $correct_password\n";
    echo "   Current: $current_password\n";
    echo "\n📝 FIXING DATABASE PASSWORD...\n";
    
    $new_env_content = preg_replace(
        '/DB_PASSWORD=.*/',
        'DB_PASSWORD=' . $correct_password,
        $env_content
    );
    
    if (file_put_contents($env_file, $new_env_content)) {
        echo "✅ Database password updated in .env\n";
    } else {
        echo "❌ Failed to update .env file\n";
        exit(1);
    }
} else {
    echo "✅ Database password is CORRECT\n";
}

echo "\n3. Clearing Laravel caches...\n";
$commands = [
    'php artisan cache:clear' => 'Application cache',
    'php artisan config:clear' => 'Configuration cache',
    'php artisan route:clear' => 'Route cache',
    'php artisan view:clear' => 'View cache',
];

foreach ($commands as $cmd => $label) {
    exec("cd '$base_path' && $cmd 2>&1", $output, $return_code);
    if ($return_code === 0) {
        echo "✅ $label cleared\n";
    } else {
        echo "⚠️  $label clear might have issues\n";
    }
}

echo "\n4. Rebuilding Laravel caches...\n";
$rebuild_commands = [
    'php artisan config:cache' => 'Configuration cache',
    'php artisan route:cache' => 'Route cache',
    'php artisan view:cache' => 'View cache',
];

foreach ($rebuild_commands as $cmd => $label) {
    exec("cd '$base_path' && $cmd 2>&1", $output, $return_code);
    if ($return_code === 0) {
        echo "✅ $label rebuilt\n";
    } else {
        echo "⚠️  $label rebuild might have issues\n";
    }
}

echo "\n5. Checking storage permissions...\n";
$storage_paths = [
    'storage',
    'storage/logs',
    'storage/framework',
    'storage/framework/views',
    'storage/framework/cache',
    'bootstrap/cache'
];

foreach ($storage_paths as $path) {
    $full_path = $base_path . '/' . $path;
    if (is_dir($full_path)) {
        echo "✅ $path exists\n";
    } else {
        echo "⚠️  $path does not exist (creating...)\n";
        @mkdir($full_path, 0755, true);
    }
}

echo "\n6. Testing database connection...\n";
try {
    require $base_path . '/bootstrap/app.php';
    $app = require $base_path . '/bootstrap/app.php';
    
    // Try a simple DB connection test
    exec("cd '$base_path' && php artisan tinker --execute=\"DB::connection()->getPdo();\" 2>&1", $db_output, $db_return);
    
    if ($db_return === 0) {
        echo "✅ Database connection successful\n";
    } else {
        echo "❌ Database connection FAILED\n";
        echo "Error details:\n";
        foreach ($db_output as $line) {
            echo "   $line\n";
        }
    }
} catch (Exception $e) {
    echo "⚠️  Could not test database connection: " . $e->getMessage() . "\n";
}

echo "\n7. Checking APP_URL configuration...\n";
preg_match('/APP_URL=(.*)/', $env_content, $app_url_match);
$app_url = isset($app_url_match[1]) ? trim($app_url_match[1]) : 'NOT SET';
echo "APP_URL: $app_url\n";

if (strpos($app_url, 'https://dmozzakr.com/plantable') === 0) {
    echo "✅ APP_URL is correctly set for live server\n";
} else {
    echo "❌ APP_URL may be incorrect for live server\n";
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
echo "\n📋 NEXT STEPS:\n";
echo "1. Check if website now loads at: https://dmozzakr.com/plantable/\n";
echo "2. If still 500 error, run: tail -50 ~/public_html/plantable/storage/logs/laravel.log\n";
echo "3. Share the error log content for further debugging\n";

?>
