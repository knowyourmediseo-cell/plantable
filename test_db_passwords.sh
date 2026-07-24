#!/bin/bash

# TEST DIFFERENT DATABASE PASSWORDS

cd ~/public_html/plantable

echo "=== TESTING DATABASE PASSWORDS ==="
echo ""
echo "Host: cs-mum-2.webhostbox.net"
echo "User: dmozzjml_plantuser"
echo "Database: dmozzjml_plant"
echo ""

# Array of passwords to test
passwords=(
    "Plant@123456@%"
    "Plant@123456@"
    "Plant@123456"
    "Plantable123"
    "plantable123"
    "Plant123456"
    "Plant123"
    "password"
    "123456"
)

echo "Testing passwords..."
echo ""

for pass in "${passwords[@]}"; do
    echo -n "Testing: $pass ... "
    
    if mysql -h cs-mum-2.webhostbox.net -u dmozzjml_plantuser -p"$pass" dmozzjml_plant -e "SELECT 1;" 2>&1 | grep -q "ERROR"; then
        echo "❌ FAILED"
    else
        echo "✅ WORKS!"
        echo ""
        echo "=== PASSWORD FOUND ==="
        echo "Correct password: $pass"
        echo ""
        echo "Run this to update .env:"
        echo "  sed -i \"s|DB_PASSWORD=.*|DB_PASSWORD=$pass|\" .env"
        echo ""
        exit 0
    fi
done

echo ""
echo "❌ None of the tested passwords worked."
echo ""
echo "Please check your hosting provider for the correct password:"
echo "  1. Contact WebhostBox support"
echo "  2. Check your hosting welcome email"
echo "  3. Try resetting password in cPanel"
echo ""

