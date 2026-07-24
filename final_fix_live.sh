#!/bin/bash

# FINAL FIX - Correct .env with proper DB host

cd ~/public_html/plantable

echo "=== FINAL FIX - CORRECTING .ENV ==="
echo ""

echo "1. Backing up current .env..."
cp .env .env.broken.backup
echo "✅ Backup saved to .env.broken.backup"
echo ""

echo "2. Applying corrected .env.live.correct..."
cp .env.live.correct .env
echo "✅ Correct config applied"
echo ""

echo "3. Verifying database configuration..."
echo "   DB_HOST: $(grep '^DB_HOST=' .env)"
echo "   DB_PORT: $(grep '^DB_PORT=' .env)"
echo "   DB_DATABASE: $(grep '^DB_DATABASE=' .env)"
echo "   DB_USERNAME: $(grep '^DB_USERNAME=' .env)"
echo "   DB_PASSWORD: $(grep '^DB_PASSWORD=' .env | cut -d'=' -f1)=***"
echo ""

echo "4. Testing database connection..."
DB_HOST=$(grep '^DB_HOST=' .env | cut -d'=' -f2)
DB_PORT=$(grep '^DB_PORT=' .env | cut -d'=' -f2)
DB_DATABASE=$(grep '^DB_DATABASE=' .env | cut -d'=' -f2)
DB_USERNAME=$(grep '^DB_USERNAME=' .env | cut -d'=' -f2)
DB_PASSWORD=$(grep '^DB_PASSWORD=' .env | cut -d'=' -f2)

php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo '✅ Database connection SUCCESSFUL!' . PHP_EOL;
    \$result = DB::selectOne('SELECT 1 as test');
    echo '✅ Query test PASSED!' . PHP_EOL;
} catch (Exception \$e) {
    echo '❌ Database connection FAILED: ' . \$e->getMessage() . PHP_EOL;
}
" 2>&1
echo ""

echo "5. Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo ""

echo "6. Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ""

echo "7. Running migrations..."
php artisan migrate --force 2>&1 | head -20
echo ""

echo "8. Testing website..."
echo "Testing: https://dmozzakr.com/plantable/"
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"
echo ""

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅✅✅ WEBSITE IS NOW WORKING! ✅✅✅"
    echo ""
    echo "Visit: https://dmozzakr.com/plantable/"
elif [ "$HTTP_CODE" = "500" ]; then
    echo "❌ Still 500 error - checking logs..."
    echo ""
    tail -30 storage/logs/laravel.log
else
    echo "⚠️  Got HTTP status: $HTTP_CODE"
fi

echo ""
echo "=== COMPLETE ==="

