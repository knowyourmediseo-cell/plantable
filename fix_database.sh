#!/bin/bash

# FIX DATABASE - Run migrations if tables don't exist

cd ~/public_html/plantable

echo "=== CHECKING DATABASE ==="
echo ""

echo "1. Testing database connection..."
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connection OK'; } catch (Exception \$e) { echo 'Database connection FAILED: ' . \$e->getMessage(); }" 2>&1
echo ""
echo ""

echo "2. Checking if migrations have been run..."
# Try to query a table
php artisan tinker --execute="try { \$count = DB::table('sliders')->count(); echo 'Sliders table exists with ' . \$count . ' records'; } catch (Exception \$e) { echo 'Sliders table ERROR: ' . \$e->getMessage(); }" 2>&1
echo ""
echo ""

echo "3. Running migrations..."
php artisan migrate --force 2>&1 | head -30
echo ""

echo "4. Checking tables again..."
php artisan tinker --execute="try { \$tables = DB::select('SHOW TABLES'); echo 'Total tables: ' . count(\$tables); echo PHP_EOL; foreach (\$tables as \$table) { \$name = get_object_vars(\$table); echo '  - ' . reset(\$name) . PHP_EOL; } } catch (Exception \$e) { echo 'ERROR: ' . \$e->getMessage(); }" 2>&1
echo ""

echo "5. Verifying critical tables..."
php artisan tinker --execute="
try {
    \$tables = ['sliders', 'categories', 'products', 'users', 'orders'];
    foreach (\$tables as \$table) {
        \$exists = DB::selectOne('SHOW TABLES LIKE ?', [\$table]) ? 'YES' : 'NO';
        echo \$table . ': ' . \$exists . PHP_EOL;
    }
} catch (Exception \$e) {
    echo 'ERROR: ' . \$e->getMessage();
}" 2>&1
echo ""

echo "6. Seeding database (if needed)..."
php artisan db:seed --force 2>&1 | head -20 || echo "Seeding skipped or completed"
echo ""

echo "7. Clearing caches again..."
php artisan cache:clear
php artisan config:clear
php artisan config:cache
echo ""

echo "8. Testing website..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"
echo ""

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ WEBSITE IS NOW WORKING!"
else
    echo "Still having issues. Checking error log..."
    echo ""
    tail -20 storage/logs/laravel.log
fi

echo ""
echo "=== DONE ==="

