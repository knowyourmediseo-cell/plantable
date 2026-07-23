# 🌱 PLANTABLE ECO - FINAL LIVE SERVER FIX GUIDE

## ✅ PROBLEM IDENTIFIED

Live server shows website but:
- ❌ Header/Footer styling broken
- ❌ CSS/JS not loading
- ❌ Internal pages not working properly
- ✅ Routes work but assets don't load from subdirectory

## ✅ ROOT CAUSE

Assets are at `~/public_html/plantable/public/` but need to be accessible as web files.  
Live server needs a symlink and correct .env configuration.

## 🚀 SOLUTION - Choose ONE Method

### METHOD 1: ONE-CLICK WEB FIX (EASIEST)

**Step 1:** SSH and pull latest code
```bash
cd ~/public_html/plantable
git pull origin main
```

**Step 2:** Open this URL in browser (it automatically fixes everything):
```
https://dmozzakr.com/plantable/fix_now.php?key=Plant@123456@%
```

**Step 3:** Wait for success message, then verify:
```
https://dmozzakr.com/plantable/
```

---

### METHOD 2: PHP-BASED FIX (ALTERNATIVE WEB)

If fix_now.php doesn't work, use:
```
https://dmozzakr.com/plantable/fix_live_complete.php?key=Plant@123456@%
```

---

### METHOD 3: BASH SCRIPT (SSH TERMINAL)

SSH and run:
```bash
cd ~/public_html/plantable && \
git pull origin main && \
bash deploy_live.sh
```

---

### METHOD 4: MANUAL SETUP (FULL CONTROL)

SSH and run each command:

```bash
# 1. Navigate to plantable
cd ~/public_html/plantable

# 2. Create symlink
ln -s public plantable_public

# 3. Create .env file
cat > .env << 'ENVEOF'
APP_NAME="Plantable Eco Products"
APP_ENV=production
APP_KEY=base64:mbfQ0NrUsDFIQu175K0Iv7gnISSr8KEMrLziZs/FCqk=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://dmozzakr.com/plantable
ASSET_URL=/plantable/plantable_public

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
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dmozzjml_plant
DB_USERNAME=dmozzjml_plantuser
DB_PASSWORD=Plant@123456@%

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

# 4. Regenerate autoloader
composer dump-autoload --optimize --ignore-platform-reqs

# 5. Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 6. Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Clear logs
> storage/logs/laravel.log

echo "✅ All fixes applied!"
```

---

## 🔍 VERIFICATION

After applying any fix method, check these URLs:

### Homepage
```
https://dmozzakr.com/plantable/
```
Should show:
- ✅ Green header with logo
- ✅ Navigation menu
- ✅ Hero section
- ✅ Footer with links

### Internal Pages
```
https://dmozzakr.com/plantable/products
https://dmozzakr.com/plantable/categories
https://dmozzakr.com/plantable/blogs
https://dmozzakr.com/plantable/gallery
```
Should show:
- ✅ Full styling
- ✅ Proper layout
- ✅ All elements visible

### Admin Panel
```
https://dmozzakr.com/plantable/admin
```
Should show:
- ✅ Login page
- ✅ Dashboard (after login)

---

## 🆘 TROUBLESHOOTING

### If still broken after fix:

1. **Check error logs:**
   ```bash
   tail -50 ~/public_html/plantable/storage/logs/laravel.log
   ```

2. **Verify .env exists:**
   ```bash
   cat ~/public_html/plantable/.env | head -20
   ```

3. **Check symlink:**
   ```bash
   ls -la ~/public_html/plantable/plantable_public
   ```

4. **Verify assets load:**
   ```bash
   curl -I https://dmozzakr.com/plantable/plantable_public/assets/app-D9PkR9ub.css
   ```
   Should return: `HTTP/1.1 200 OK`

5. **Check database:**
   ```bash
   mysql -u dmozzjml_plantuser -p -e "USE dmozzjml_plant; SELECT 1;"
   # Password: Plant@123456@%
   ```

---

## 📋 WHAT EACH FIX DOES

| Step | Action | Purpose |
|------|--------|---------|
| 1 | Create symlink | Make `public/` accessible via web as `plantable_public/` |
| 2 | Create .env | Configure Laravel for live server (URL, DB, sessions) |
| 3 | Autoloader | Ensure PHP can find all classes |
| 4 | Clear caches | Remove old configuration |
| 5 | Rebuild caches | Generate new configuration for live |
| 6 | Clear logs | Remove error logs for clean slate |

---

## ✨ EXPECTED RESULT

After fix:
- ✅ Website loads at https://dmozzakr.com/plantable/
- ✅ Header displays with full green styling
- ✅ Footer displays with company info
- ✅ All CSS/JS loads (check DevTools Network tab)
- ✅ All pages accessible
- ✅ No 404 errors for assets
- ✅ No console errors
- ✅ Database working
- ✅ Session working for logged-in users

---

## 🎯 RECOMMENDATION

Use **METHOD 1** (One-Click Web Fix) - it's the easiest and most reliable:

1. SSH: `cd ~/public_html/plantable && git pull origin main`
2. Browser: `https://dmozzakr.com/plantable/fix_now.php?key=Plant@123456@%`
3. Wait for success message
4. Verify: `https://dmozzakr.com/plantable/`

Done! ✅

---

**Last Updated:** July 23, 2026  
**Status:** Ready for Production ✅
