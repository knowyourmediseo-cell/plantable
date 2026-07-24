#!/bin/bash

# COMPREHENSIVE LIVE SERVER DIAGNOSTIC
# Run as: bash live_full_diagnostic.sh

cd ~/public_html/plantable

echo "=== PLANTABLE ECO LIVE DEPLOYMENT DIAGNOSTIC ==="
echo ""
echo "1. PULLING LATEST CODE..."
git pull origin main
echo ""

echo "2. CHECKING .ENV FILE..."
if [ ! -f .env ]; then
    echo "❌ .env file missing!"
    exit 1
fi
echo "✅ .env exists"
echo ""

echo "3. VERIFYING DATABASE PASSWORD..."
DB_PASS=$(grep "DB_PASSWORD=" .env | cut -d'=' -f2)
if [ "$DB_PASS" != "Plant@123456@%" ]; then
    echo "❌ Database password is WRONG: $DB_PASS"
    echo "   Fixing..."
    sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=Plant@123456@%|" .env
    echo "✅ Password fixed"
else
    echo "✅ Database password is correct"
fi
echo ""

echo "4. CLEARING ALL CACHES..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear  
php artisan view:clear
echo ""

echo "5. REBUILDING CACHES..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ""

echo "6. CHECKING STORAGE PERMISSIONS..."
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p bootstrap/cache
chmod -R 755 storage bootstrap
echo "✅ Storage directories created"
echo ""

echo "7. CLEARING ERROR LOG..."
> storage/logs/laravel.log
echo "✅ Error log cleared"
echo ""

echo "8. TESTING BASIC REQUEST..."
php -r "
require 'bootstrap/app.php';
\$app = require 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Http\Kernel::class);
\$request = Illuminate\Http\Request::capture();
try {
    \$response = \$kernel->handle(\$request);
    echo '✅ Request handling works' . PHP_EOL;
} catch (Exception \$e) {
    echo '❌ Request handling failed: ' . \$e->getMessage() . PHP_EOL;
}
"
echo ""

echo "9. CHECKING LARAVEL ERROR LOG..."
if [ -f storage/logs/laravel.log ]; then
    if [ -s storage/logs/laravel.log ]; then
        echo "📋 Error log contents (last 50 lines):"
        echo "---"
        tail -50 storage/logs/laravel.log
        echo "---"
    else
        echo "✅ No errors in log"
    fi
else
    echo "⚠️  Error log file doesn't exist yet"
fi
echo ""

echo "10. TESTING WEBSITE ACCESS..."
curl -I https://dmozzakr.com/plantable/ 2>&1 | grep "HTTP"
echo ""

echo "=== DIAGNOSTIC COMPLETE ==="
echo ""
echo "If still 500 error, check these files:"
echo "  cat storage/logs/laravel.log"
echo "  cat /var/log/apache2/error_log"
echo "  cat /var/log/apache2/dmozzakr.com-error_log (if exists)"
echo ""

