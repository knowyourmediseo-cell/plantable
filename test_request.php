<?php
/**
 * TEST REQUEST SCRIPT
 * Simulates accessing the /plantable/ URL and shows errors
 */

$base_path = __DIR__;

// Simulate the live server request
$_SERVER['REQUEST_URI'] = '/plantable/';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SERVER_NAME'] = 'dmozzakr.com';
$_SERVER['SERVER_PORT'] = '443';
$_SERVER['HTTPS'] = 'on';
$_SERVER['HTTP_HOST'] = 'dmozzakr.com';

echo "=== TESTING REQUEST SIMULATION ===\n";
echo "Base path: $base_path\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n\n";

// Enable error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Step 1: Loading bootstrap...\n";
try {
    $app = require $base_path . '/bootstrap/app.php';
    echo "✅ Bootstrap loaded\n";
} catch (Throwable $e) {
    echo "❌ Bootstrap failed:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
    exit(1);
}

echo "\nStep 2: Getting HTTP Kernel...\n";
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "✅ HTTP Kernel retrieved\n";
} catch (Throwable $e) {
    echo "❌ HTTP Kernel failed:\n";
    echo "   " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nStep 3: Creating request...\n";
try {
    $request = Illuminate\Http\Request::capture();
    echo "✅ Request created\n";
    echo "   Path: " . $request->path() . "\n";
    echo "   Method: " . $request->method() . "\n";
    echo "   Host: " . $request->getHost() . "\n";
} catch (Throwable $e) {
    echo "❌ Request creation failed:\n";
    echo "   " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nStep 4: Handling request...\n";
try {
    $response = $kernel->handle($request);
    echo "✅ Request handled\n";
    echo "   Status: " . $response->status() . "\n";
} catch (Throwable $e) {
    echo "❌ REQUEST HANDLING FAILED\n";
    echo "\n🔴 ERROR:\n";
    echo "   Type: " . get_class($e) . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
    
    echo "\n📍 Stack trace:\n";
    $i = 1;
    foreach ($e->getTrace() as $trace) {
        echo "   [$i] " . ($trace['file'] ?? 'unknown') . ":" . ($trace['line'] ?? '?') . "\n";
        echo "       " . ($trace['class'] ?? '') . ($trace['type'] ?? '') . ($trace['function'] ?? '') . "()\n";
        $i++;
        if ($i > 10) {
            echo "   ... (truncated)\n";
            break;
        }
    }
    exit(1);
}

echo "\n✅ SUCCESS - Request processing completed\n";

?>
