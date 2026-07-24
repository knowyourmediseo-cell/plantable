#!/bin/bash

# Find files with problematic characters (newlines, spaces, etc)

cd ~/public_html/plantable

echo "=== SEARCHING FOR PROBLEMATIC FILES ==="
echo ""

echo "1. Files with newlines in name:"
find . -type f -name '*
*' 2>/dev/null | head -20

echo ""
echo "2. Checking specific directories:"
ls -la app/Http/Controllers/Admin/ | grep $'\n' || echo "No newlines in Admin controllers"

echo ""
echo "3. Looking for hidden/special files:"
find . -type f ! -path '*/.*' -print0 2>/dev/null | xargs -0 ls -1 | grep -E '[\r\n]' || echo "Searching..."

echo ""
echo "4. Checking storage directory:"
find storage -type f 2>/dev/null | head -20

echo ""
echo "5. Checking bootstrap cache:"
find bootstrap/cache -type f 2>/dev/null | head -20

echo ""
echo "6. Running raw find (ignore errors):"
find . -type f 2>&1 | grep -i "newline\|stat" | head -20

