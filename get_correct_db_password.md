# DATABASE PASSWORD FIX

The website is failing because the database password is **incorrect**.

## Current Error:
```
Access denied for user 'dmozzjml_plantuser'@'cs-mum-2.webhostbox.net' (using password: YES)
```

The password `Plant@123456@%` is being rejected.

---

## HOW TO FIX:

### Option 1: Check the correct password from your hosting provider

1. Go to your **cPanel** at: https://cpanel.dmozzakr.com
2. Login with your cPanel username and password
3. Find **MySQL Databases** or **MySQL Users**
4. Look for user: `dmozzjml_plantuser`
5. Check what password is set (or reset it to something simple)
6. Copy the correct password

### Option 2: Reset the database password

If you have cPanel access:
1. In cPanel, go to **MySQL Users**
2. Find `dmozzjml_plantuser`
3. Click "Change Password"
4. Set it to: `Plantable@2026` (or any password without special # characters)

### Option 3: Test different passwords

Run this command on the live server (replace PASSWORD):
```bash
mysql -h cs-mum-2.webhostbox.net -u dmozzjml_plantuser -p'PASSWORD' dmozzjml_plant -e "SELECT 1;" 2>&1
```

---

## ONCE YOU HAVE THE CORRECT PASSWORD:

Run this on the live server:
```bash
cd ~/public_html/plantable && \
sed -i 's|DB_PASSWORD=.*|DB_PASSWORD=CORRECT_PASSWORD_HERE|' .env && \
php artisan cache:clear && \
php artisan config:clear && \
php artisan config:cache && \
curl -I https://dmozzakr.com/plantable/
```

Replace `CORRECT_PASSWORD_HERE` with the actual password.

---

## Need direct help?

If you can't access cPanel or reset the password, contact your hosting provider (WebhostBox) and ask them for:
- Database host: `cs-mum-2.webhostbox.net`
- Database: `dmozzjml_plant`
- Username: `dmozzjml_plantuser`
- Current password or to reset it

They will provide the correct credentials.
