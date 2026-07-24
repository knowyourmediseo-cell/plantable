#!/bin/bash

# QUICK FIX - Quote the password properly

cd ~/public_html/plantable

echo "=== FIXING DATABASE PASSWORD FORMAT ==="
echo ""

echo "1. Updating .env with properly quoted password..."
sed -i 's|DB_PASSWORD=plant@123456@%|DB_PASSWORD="plant@123456@%"|' .env
echo "✅ Password quoted"
echo ""

echo "2. Verifying .env..."
grep "DB_PASSWORD=" .env
echo ""

echo "3. Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan config:cache
echo ""

echo "4. Testing database..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo '✅ Database connection SUCCESSFUL!' . PHP_EOL;
} catch (Exception \$e) {
    echo '❌ Failed: ' . \$e->getMessage() . PHP_EOL;
}
" 2>&1
echo ""

echo "5. Testing website..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"
echo ""

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅✅✅ WEBSITE IS WORKING! ✅✅✅"
else
    echo "Still having issues. Output:"
    curl -s https://dmozzakr.com/plantable/ | head -100
fi

echo ""
echo "=== DONE ==="

