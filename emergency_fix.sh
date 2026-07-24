#!/bin/bash

# EMERGENCY FIX - Remove quotes and try raw password

cd ~/public_html/plantable

echo "=== EMERGENCY DATABASE FIX ==="
echo ""

echo "1. Removing quotes from password..."
sed -i 's|DB_PASSWORD="plant@123456@%"|DB_PASSWORD=plant@123456@%|' .env
sed -i "s|DB_PASSWORD='plant@123456@%'|DB_PASSWORD=plant@123456@%|" .env

echo "2. Current password setting:"
grep "DB_PASSWORD=" .env
echo ""

echo "3. Testing MySQL directly with no quotes..."
echo "Testing: mysql -h 43.225.54.100 -u dmozzjml_plantuser -pplant@123456@% dmozzjml_plant"
mysql -h 43.225.54.100 -u dmozzjml_plantuser -pplant@123456@% dmozzjml_plant -e "SELECT 1 as test;" 2>&1
echo ""

echo "4. Clearing caches..."
php artisan cache:clear
php artisan config:clear  
php artisan config:cache
echo ""

echo "5. Testing Laravel connection..."
php artisan tinker --execute="
try {
    \$result = DB::selectOne('SELECT 1 as test');
    echo '✅ CONNECTION WORKS!' . PHP_EOL;
} catch (Exception \$e) {
    echo '❌ FAILED: ' . \$e->getMessage() . PHP_EOL;
}
" 2>&1 | grep -E "(✅|❌|FAILED)"

echo ""
echo "6. Testing website..."
curl -s -o /dev/null -w "HTTP %{http_code}\n" https://dmozzakr.com/plantable/
echo ""

echo "=== DONE ==="

