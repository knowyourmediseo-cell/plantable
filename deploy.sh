#!/bin/bash

# Plantable Eco - Quick Deployment Script
# Usage: chmod +x deploy.sh && ./deploy.sh

echo "================================"
echo "Plantable Eco - Quick Deploy"
echo "================================"

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# Step 1: Commit and push current changes
echo -e "\n${YELLOW}Step 1: Pushing code to GitHub...${NC}"
git add .
git commit -m "Quick deployment - $(date +%Y-%m-%d\ %H:%M:%S)" 2>/dev/null || echo "No changes to commit"
git push origin main

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Code pushed successfully${NC}"
else
    echo -e "${RED}✗ Failed to push code${NC}"
    exit 1
fi

# Step 2: SSH commands to run on live server
echo -e "\n${YELLOW}Step 2: Running commands on live server...${NC}"
echo "Connecting to live server and running deployment commands..."

ssh dmozzjml@dmozzakr.com << 'EOF'
cd ~/public_html/plantable
echo "Pulling latest code..."
git pull origin main

echo "Dumping autoloader..."
composer dump-autoload --optimize

echo "Clearing and caching configuration..."
php artisan config:clear
php artisan config:cache

echo "Clearing and caching routes..."
php artisan route:clear
php artisan route:cache

echo "Clearing and caching views..."
php artisan view:clear
php artisan view:cache

echo "Clearing all caches..."
php artisan cache:clear

echo "✓ Deployment completed successfully!"
EOF

if [ $? -eq 0 ]; then
    echo -e "\n${GREEN}✓ Live server updated successfully${NC}"
else
    echo -e "\n${RED}✗ Failed to update live server${NC}"
    exit 1
fi

echo -e "\n${GREEN}================================"
echo "Deployment Complete!"
echo "Check: https://dmozzakr.com/plantable/"
echo "================================${NC}"
