#!/bin/bash

# APPLY CORRECT LIVE SERVER CONFIGURATION
# This script applies the .env.live settings to the live server

cd ~/public_html/plantable

echo "=== APPLYING LIVE CONFIGURATION ==="
echo ""

if [ ! -f ".env.live" ]; then
    echo "❌ .env.live not found - pulling from GitHub first..."
    git pull origin main
fi

echo "1. BACKING UP CURRENT .env..."
cp .env .env.backup.$(date +%s)
echo "✅ Backup created"
echo ""

echo "2. COPYING .env.live to .env..."
cp .env.live .env
echo "✅ Configuration applied"
echo ""

echo "3. VERIFYING CRITICAL SETTINGS..."
echo "   APP_URL: $(grep "APP_URL=" .env)"
echo "   DB_DATABASE: $(grep "DB_DATABASE=" .env)"
echo "   DB_USERNAME: $(grep "DB_USERNAME=" .env)"
echo "   DB_PASSWORD: $(grep "DB_PASSWORD=" .env | cut -d= -f1)=***"
echo ""

echo "4. CLEARING ALL CACHES..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "✅ Caches cleared"
echo ""

echo "5. REBUILDING CACHES..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Caches rebuilt"
echo ""

echo "6. TESTING WEBSITE..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"
echo ""

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ WEBSITE IS NOW WORKING!"
elif [ "$HTTP_CODE" = "500" ]; then
    echo "❌ Still showing 500 error"
    echo ""
    echo "Error log (last 30 lines):"
    tail -30 storage/logs/laravel.log
else
    echo "⚠️  Got HTTP status: $HTTP_CODE"
fi

echo ""
echo "=== DONE ==="

