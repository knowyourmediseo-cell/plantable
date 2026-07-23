#!/bin/bash
set -e

echo "🚀 Starting Plantable Eco Deployment to cPanel..."

# Variables
DOMAIN="dmozzakr.com"
SUBDOMAIN_PATH="public_html/plantable"
DB_NAME="dmozzjml_plant"
DB_USER="dmozzjml_plantuser"

echo "📦 Step 1: Installing dependencies..."
composer install --optimize-autoloader --no-dev
npm install
npm run build

echo "🔑 Step 2: Setting up environment..."
cp .env.production .env

echo "🗝️ Step 3: Generating app key..."
php artisan key:generate --force

echo "💾 Step 4: Running migrations..."
php artisan migrate --force

echo "🔗 Step 5: Creating storage link..."
php artisan storage:link

echo "⚡ Step 6: Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "📁 Step 7: Setting permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "✅ Deployment complete!"
echo "🌐 Access: https://$DOMAIN/plantable"
