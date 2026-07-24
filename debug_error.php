<?php
/**
 * QUICK DEBUG SCRIPT
 * This shows the actual error without needing logs
 */

// Set error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "=== PLANTABLE ECO DEBUG ===\n\n";

$base = __DIR__;

// 1. Check basic file structure
echo "1. Checking file structure...\n";
$files_to_check = [
    'public/index.php',
    'bootstrap/app.php',
    'app/Http/Kernel.php',
    '.env',
];

foreach ($files_to_check as $file) {
    $path = "$base/$file";
    echo "   " . (file_exists($path) ? "✅" : "❌") . " $file\n";
}

echo "\n2. Checking if Laravel can bootstrap...\n";
try {
    $app = require $base . '/bootstrap/app.php';
    echo "✅ Laravel bootstrap successful\n";
} catch (Exception $e) {
    echo "❌ Laravel bootstrap FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}

echo "\n3. Checking configuration...\n";
try {
    $app->make('config');
    echo "✅ Configuration loading successful\n";
} catch (Exception $e) {
    echo "❌ Configuration loading FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n4. Checking database connection...\n";
try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $db = $app->make('db');
    $pdo = $db->connection()->getPdo();
    echo "✅ Database connection successful\n";
} catch (Exception $e) {
    echo "❌ Database connection FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Type: " . get_class($e) . "\n";
}

echo "\n5. Testing HTTP request handling...\n";
try {
    // Create a test request
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    
    echo "✅ HTTP kernel initialization successful\n";
    echo "   Request path: " . $request->path() . "\n";
    echo "   Request method: " . $request->method() . "\n";
} catch (Exception $e) {
    echo "❌ HTTP kernel FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n6. Attempting to process request...\n";
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    
    echo "✅ Request handled successfully\n";
    echo "   Status: " . $response->status() . "\n";
} catch (Exception $e) {
    echo "❌ Request handling FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== END DEBUG ===\n";
?>
