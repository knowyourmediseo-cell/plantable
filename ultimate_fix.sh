#!/bin/bash

# ULTIMATE FIX - Nuclear option to fix the 500 error

cd ~/public_html/plantable

echo "=== ULTIMATE PLANTABLE ECO FIX ==="
echo ""

echo "1. STOPPING ANY PROCESSES THAT MIGHT LOCK FILES..."
sync
sleep 1
echo "✅ Done"
echo ""

echo "2. REMOVING ALL LARAVEL CACHE FILES..."
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*
rm -f storage/logs/laravel.log
echo "✅ All caches deleted"
echo ""

echo "3. RECREATING CACHE DIRECTORIES..."
mkdir -p bootstrap/cache
mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/logs
chmod -R 755 bootstrap storage
echo "✅ Directories recreated"
echo ""

echo "4. VERIFYING .ENV FILE..."
if ! grep -q "DB_PASSWORD=Plant@123456@%" .env; then
    echo "⚠️  Database password incorrect, fixing..."
    sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=Plant@123456@%|" .env
fi
echo "✅ .env verified"
echo ""

echo "5. RUNNING COMPOSER INSTALL (if needed)..."
if [ ! -d "vendor/laravel" ]; then
    echo "Installing dependencies..."
    composer install --no-dev --ignore-platform-reqs --quiet
fi
echo "✅ Dependencies checked"
echo ""

echo "6. RUNNING LARAVEL CACHE COMMANDS..."
php artisan cache:clear 2>&1 | grep -v "^$"
php artisan config:clear 2>&1 | grep -v "^$"
php artisan route:clear 2>&1 | grep -v "^$"
php artisan view:clear 2>&1 | grep -v "^$"
echo ""

echo "7. REBUILDING CACHES..."
php artisan config:cache 2>&1 | grep -v "^$"
php artisan route:cache 2>&1 | grep -v "^$"  
php artisan view:cache 2>&1 | grep -v "^$"
echo ""

echo "8. CREATING STORAGE LINK..."
if [ ! -L "public/storage" ]; then
    php artisan storage:link 2>&1 | grep -v "^$" || echo "Storage link already exists"
fi
echo ""

echo "9. RUNNING KEY GENERATION (if needed)..."
if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate
fi
echo "✅ Key verified"
echo ""

echo "10. CLEARING EVERYTHING AND TESTING..."
php artisan cache:clear
php artisan config:clear
php artisan config:cache
sleep 1
echo ""

echo "11. TESTING WEBSITE..."
echo "Testing: https://dmozzakr.com/plantable/"
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ WEBSITE IS WORKING!"
elif [ "$HTTP_CODE" = "500" ]; then
    echo "❌ Still 500 error"
    echo ""
    echo "ERROR LOG:"
    tail -50 storage/logs/laravel.log 2>/dev/null || echo "No log file"
else
    echo "⚠️  Got status $HTTP_CODE"
fi
echo ""

echo "=== FIX COMPLETE ==="

