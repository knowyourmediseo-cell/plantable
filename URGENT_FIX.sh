#!/bin/bash

# URGENT FIX - Try all possible solutions

cd ~/public_html/plantable

echo "=== URGENT FIX - ATTEMPTING ALL SOLUTIONS ==="
echo ""

# Solution 1: Try without quotes
echo "SOLUTION 1: Removing quotes from password..."
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=plant@123456@%/' .env
php artisan config:cache
mysql -h 43.225.54.100 -u dmozzjml_plantuser -pplant@123456@% dmozzjml_plant -e "SELECT 1;" 2>&1 | grep -q "ERROR" || echo "✅ Password works!" && exit 0
echo ""

# Solution 2: Try different password variations
echo "SOLUTION 2: Trying password variations..."
for pass in "Plant@123456@%" "plant@123456@%" "Plantable@123" "plantable123" "Plant123456"; do
    echo "  Testing: $pass"
    if mysql -h 43.225.54.100 -u dmozzjml_plantuser -p"$pass" dmozzjml_plant -e "SELECT 1;" 2>&1 | grep -q "ERROR"; then
        :
    else
        echo "  ✅ FOUND WORKING PASSWORD: $pass"
        sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$pass/" .env
        php artisan cache:clear && php artisan config:cache
        exit 0
    fi
done
echo ""

# Solution 3: Try localhost instead of IP
echo "SOLUTION 3: Trying localhost connection..."
if mysql -h localhost -u dmozzjml_plantuser -pplant@123456@% dmozzjml_plant -e "SELECT 1;" 2>&1 | grep -q "ERROR"; then
    :
else
    echo "✅ Localhost works! Updating .env..."
    sed -i 's/DB_HOST=.*/DB_HOST=localhost/' .env
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=plant@123456@%/' .env
    php artisan cache:clear && php artisan config:cache
    exit 0
fi
echo ""

# Solution 4: Check if we have a backup .env
echo "SOLUTION 4: Checking for backup .env files..."
if [ -f ".env.backup" ]; then
    echo "Found .env.backup - restoring..."
    cp .env.backup .env
    php artisan cache:clear && php artisan config:cache
    mysql -h $(grep DB_HOST .env | cut -d= -f2) -u $(grep DB_USERNAME .env | cut -d= -f2) -p$(grep DB_PASSWORD .env | cut -d= -f2) $(grep DB_DATABASE .env | cut -d= -f2) -e "SELECT 1;" 2>&1 | grep -q "ERROR" || echo "✅ Backup restore works!" && exit 0
fi
echo ""

# Solution 5: Show current config for manual checking
echo "SOLUTION 5: Current database configuration:"
echo "DB_HOST: $(grep DB_HOST .env | cut -d= -f2)"
echo "DB_PORT: $(grep DB_PORT .env | cut -d= -f2)"
echo "DB_DATABASE: $(grep DB_DATABASE .env | cut -d= -f2)"
echo "DB_USERNAME: $(grep DB_USERNAME .env | cut -d= -f2)"
echo "DB_PASSWORD: $(grep DB_PASSWORD .env | cut -d= -f2)"
echo ""

echo "❌ Could not fix automatically."
echo ""
echo "MANUAL STEPS:"
echo "1. Go to cpanel.dmozzakr.com"
echo "2. Find MySQL Users section"
echo "3. Find 'dmozzjml_plantuser'"
echo "4. Reset password to something simple (e.g., 'Plantable123')"
echo "5. Update .env: sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=Plantable123/' .env"
echo "6. Run: php artisan cache:clear && php artisan config:cache"
echo ""
echo "=== END ==="

