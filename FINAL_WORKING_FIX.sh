#!/bin/bash

# FINAL WORKING FIX - Correct username and password

cd ~/public_html/plantable

echo "=== FINAL WORKING FIX ==="
echo ""

echo "1. Updating .env with CORRECT credentials..."
cat > .env << 'ENVEOF'
APP_NAME="Plantable Eco Products"
APP_ENV=production
APP_KEY=base64:mbfQ0NrUsDFIQu175K0Iv7gnISSr8KEMrLziZs/FCqk=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://dmozzakr.com/plantable
ASSET_URL=/plantable/public

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=dmozzjml_plant
DB_USERNAME=dmozzjml_plant
DB_PASSWORD=Plantable123

SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/plantable/
SESSION_DOMAIN=.dmozzakr.com

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=array
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@plantableeco.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=

RAZORPAY_KEY=
RAZORPAY_SECRET=

PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=

GOOGLE_ANALYTICS_ID=
FACEBOOK_PIXEL_ID=
GTM_ID=
ENVEOF

echo "✅ .env updated"
echo ""

echo "2. Verifying credentials..."
echo "DB_HOST: $(grep '^DB_HOST=' .env)"
echo "DB_DATABASE: $(grep '^DB_DATABASE=' .env)"
echo "DB_USERNAME: $(grep '^DB_USERNAME=' .env)"
echo "DB_PASSWORD: $(grep '^DB_PASSWORD=' .env | cut -d'=' -f1)=***"
echo ""

echo "3. Testing database connection..."
mysql -h localhost -u dmozzjml_plant -pPlantable123 dmozzjml_plant -e "SELECT 1 as connection_test;" 2>&1
echo ""

echo "4. Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo ""

echo "5. Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ""

echo "6. Running migrations (if not already done)..."
php artisan migrate --force 2>&1 | head -10
echo ""

echo "7. Testing website..."
echo "Testing: https://dmozzakr.com/plantable/"
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://dmozzakr.com/plantable/)
echo "HTTP Status: $HTTP_CODE"
echo ""

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅✅✅ WEBSITE IS NOW WORKING! ✅✅✅"
    echo ""
    echo "Visit: https://dmozzakr.com/plantable/"
    echo ""
    echo "Your website is LIVE with:"
    echo "  - Correct database: dmozzjml_plant"
    echo "  - Correct username: dmozzjml_plant"
    echo "  - Correct password: Plantable123"
else
    echo "Still having issues. Checking error log..."
    echo ""
    tail -30 storage/logs/laravel.log
fi

echo ""
echo "=== COMPLETE ==="

