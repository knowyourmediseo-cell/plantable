#!/bin/bash

# VERIFY DATABASE PASSWORD

cd ~/public_html/plantable

echo "=== DATABASE PASSWORD VERIFICATION ==="
echo ""

echo "1. Current .env DB settings:"
echo "   DB_HOST: $(grep 'DB_HOST=' .env)"
echo "   DB_PORT: $(grep 'DB_PORT=' .env)"
echo "   DB_DATABASE: $(grep 'DB_DATABASE=' .env)"
echo "   DB_USERNAME: $(grep 'DB_USERNAME=' .env)"
echo "   DB_PASSWORD: $(grep 'DB_PASSWORD=' .env | cut -d'=' -f1)=***"
echo ""

DB_HOST=$(grep 'DB_HOST=' .env | cut -d'=' -f2)
DB_PORT=$(grep 'DB_PORT=' .env | cut -d'=' -f2)
DB_DATABASE=$(grep 'DB_DATABASE=' .env | cut -d'=' -f2)
DB_USERNAME=$(grep 'DB_USERNAME=' .env | cut -d'=' -f2)
DB_PASSWORD=$(grep 'DB_PASSWORD=' .env | cut -d'=' -f2)

echo "2. Trying passwords..."
echo ""

# Try current password
echo "   Testing: $DB_PASSWORD"
mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT 1;" 2>&1 | grep -q "ERROR" && echo "   ❌ FAILED" || echo "   ✅ WORKS"

echo ""
echo "3. If password is wrong, check cPanel:"
echo "   1. Go to cpanel.dmozzakr.com"
echo "   2. Login with your cPanel credentials"
echo "   3. MySQL Users section"
echo "   4. Find 'dmozzjml_plantuser'"
echo "   5. Reset password or copy correct one"
echo ""

echo "4. Or try connecting manually:"
echo "   mysql -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE"
echo "   (It will prompt for password - paste the correct one)"
echo ""

echo "=== END ==="

