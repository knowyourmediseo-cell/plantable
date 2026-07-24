#!/bin/bash

# FIX PASSWORD WITH PROPER ESCAPING

cd ~/public_html/plantable

echo "=== FIXING PASSWORD WITH ESCAPING ==="
echo ""

echo "1. Updating .env with escaped password..."
# Use URL encoding or base64 encoding approach
sed -i 's|DB_PASSWORD="plant@123456@%"|DB_PASSWORD=plant%40123456%40%25|' .env

echo "Trying different formats..."
echo ""

# Try format 1: with quotes
echo "Format 1: Quoted password"
sed -i 's|DB_PASSWORD=.*|DB_PASSWORD="plant@123456@%"|' .env
php artisan tinker --execute="echo 'DB_PASSWORD: ' . config('database.connections.mysql.password');" 2>&1 | grep -i "DB_PASSWORD" && echo "✅ Read successfully" || echo "⚠️  Format 1 didn't work"

echo ""
echo "Format 2: Without quotes but with backslash escape"
sed -i 's|DB_PASSWORD=.*|DB_PASSWORD=plant\\@123456\\@%|' .env
php artisan tinker --execute="echo 'DB_PASSWORD: ' . config('database.connections.mysql.password');" 2>&1 | grep -i "plant" && echo "✅ Read successfully" || echo "⚠️  Format 2 didn't work"

echo ""
echo "Format 3: Single quotes"
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD='plant@123456@%'|" .env
php artisan tinker --execute="echo 'DB_PASSWORD: ' . config('database.connections.mysql.password');" 2>&1 | grep -i "plant" && echo "✅ Read successfully" || echo "⚠️  Format 3 didn't work"

echo ""
echo "Current .env DB_PASSWORD line:"
grep "DB_PASSWORD=" .env

echo ""
echo "2. Testing database connection..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo '✅ Database connection WORKS!' . PHP_EOL;
    exit(0);
} catch (Exception \$e) {
    echo '❌ Still failing: ' . \$e->getMessage() . PHP_EOL;
    exit(1);
}
" 2>&1

echo ""
echo "3. Testing website..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ WEBSITE WORKS!"
fi

echo ""
echo "=== DONE ==="

