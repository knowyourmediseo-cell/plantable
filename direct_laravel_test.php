<?php
/**
 * DIRECT LARAVEL TEST
 * Bypasses routing - calls Laravel directly
 */

echo "=== DIRECT LARAVEL TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

$base = __DIR__;

try {
    echo "1. Checking bootstrap file...\n";
    if (!file_exists("$base/bootstrap/app.php")) {
        die("❌ bootstrap/app.php not found\n");
    }
    echo "✅ Found\n\n";
    
    echo "2. Loading Laravel bootstrap...\n";
    $app = require "$base/bootstrap/app.php";
    echo "✅ Loaded\n\n";
    
    echo "3. Getting kernel...\n";
    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
    echo "✅ Kernel ready\n\n";
    
    echo "4. Creating request...\n";
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['PATH_INFO'] = '/';
    $_SERVER['SCRIPT_NAME'] = '/plantable/index.php';
    $_SERVER['SCRIPT_FILENAME'] = "$base/public/index.php";
    
    $request = \Illuminate\Http\Request::capture();
    echo "✅ Request created\n";
    echo "   Path: " . $request->path() . "\n";
    echo "   URL: " . $request->url() . "\n\n";
    
    echo "5. Handling request...\n";
    $response = $kernel->handle($request);
    echo "✅ Response generated\n";
    echo "   Status: " . $response->status() . "\n";
    echo "   Content length: " . strlen($response->getContent()) . "\n\n";
    
    if ($response->status() === 200) {
        echo "✅✅✅ SUCCESS - WEBSITE IS WORKING! ✅✅✅\n";
    } else {
        echo "⚠️  Response status: " . $response->status() . "\n";
    }
    
    // Send the response
    $kernel->terminate($request, $response);
    
} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    
    // Try to show more details
    echo "Stack trace:\n";
    foreach (array_slice($e->getTrace(), 0, 10) as $i => $trace) {
        $file = $trace['file'] ?? 'unknown';
        $line = $trace['line'] ?? '?';
        $func = $trace['function'] ?? 'unknown';
        echo "  [$i] $file:$line in $func()\n";
    }
}

?>
