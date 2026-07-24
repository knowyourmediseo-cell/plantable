#!/bin/bash

# CHECK ACTUAL DATABASE HOST

echo "=== CHECKING DATABASE HOST ==="
echo ""

echo "1. Checking /etc/hosts..."
cat /etc/hosts | grep -i mysql || echo "No mysql entry in /etc/hosts"
echo ""

echo "2. Checking if 43.225.54.100 is reachable..."
ping -c 1 43.225.54.100 2>&1 | head -3
echo ""

echo "3. Checking if cs-mum-2.webhostbox.net is reachable..."
ping -c 1 cs-mum-2.webhostbox.net 2>&1 | head -3
echo ""

echo "4. Current .env DB settings:"
grep "^DB_" ~/public_html/plantable/.env | head -6
echo ""

echo "5. Trying localhost connection..."
mysql -h localhost -u dmozzjml_plantuser -p'plant@123456@%' dmozzjml_plant -e "SELECT 1;" 2>&1
echo ""

echo "6. Trying 127.0.0.1 connection..."
mysql -h 127.0.0.1 -u dmozzjml_plantuser -p'plant@123456@%' dmozzjml_plant -e "SELECT 1;" 2>&1
echo ""

echo "7. Trying IP connection..."
mysql -h 43.225.54.100 -u dmozzjml_plantuser -p'plant@123456@%' dmozzjml_plant -e "SELECT 1;" 2>&1
echo ""

echo "8. Trying hostname connection..."
mysql -h cs-mum-2.webhostbox.net -u dmozzjml_plantuser -p'plant@123456@%' dmozzjml_plant -e "SELECT 1;" 2>&1
echo ""

echo "9. Checking if database exists locally..."
mysql -u root -e "SHOW DATABASES LIKE 'dmozzjml_plant';" 2>&1 || echo "No local access"
echo ""

echo "=== END ==="

