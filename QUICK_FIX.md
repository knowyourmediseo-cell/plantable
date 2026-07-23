# Quick Fix for Live Server - 500 Error

## Problem
The live server is showing a 500 error with "Call to undefined function" because the composer autoloader hasn't been regenerated after deployment.

## Quick Fix - 3 Step Process

### Step 1: Pull Latest Code
SSH into the live server and run:
```bash
cd ~/public_html/plantable
git pull origin main
```

### Step 2: Run Autoloader Dump
```bash
composer dump-autoload --optimize
```

### Step 3: Clear All Caches
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear
```

## Alternative - Use Web Script
If you can't SSH, access this URL in your browser:
```
https://dmozzakr.com/plantable/fix_live.php?key=Plant@123456@%
```

This will automatically run all the necessary commands and show you the output.

## Expected Result
After running these commands, the website should load without errors.

## If Still Not Working
1. Check error logs: `~/public_html/plantable/storage/logs/laravel.log`
2. Verify `.env` file has `VIEW_CACHE_PATH` set correctly
3. Ensure directory permissions are correct on `storage/` and `bootstrap/cache`
