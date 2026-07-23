# Live Deployment Setup & Automatic GitHub Deployment

## Step 1: Immediate Fix (Run on cPanel Terminal NOW)

```bash
# Add VIEW_CACHE_PATH to live .env
echo "" >> ~/public_html/plantable/.env
echo "VIEW_CACHE_PATH=/home2/dmozzjml/public_html/plantable/storage/framework/views" >> ~/public_html/plantable/.env

# Clear caches
rm -rf ~/public_html/plantable/bootstrap/cache/*
rm -rf ~/public_html/plantable/storage/framework/cache/*
rm -rf ~/public_html/plantable/storage/framework/views/*

# Set proper permissions
chmod -R 755 ~/public_html/plantable/storage ~/public_html/plantable/bootstrap/cache

# Test if website loads now
curl https://dmozzakr.com/plantable/
```

**Expected Result:** You should see HTML of the homepage, NOT the loader animation.

---

## Step 2: Setup Automatic GitHub Deployment

### 2.1 Generate SSH Key on Your Server

Run this on your cPanel terminal:

```bash
# Generate SSH key (press Enter 3 times to use defaults)
ssh-keygen -t rsa -b 4096 -f ~/.ssh/github_deploy -N ""

# Display the private key (you'll need this)
cat ~/.ssh/github_deploy

# Display the public key (add to server authorized_keys)
cat ~/.ssh/github_deploy.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### 2.2 Add GitHub Secrets

Go to your GitHub repository → Settings → Secrets and variables → Actions → New repository secret

Add these 3 secrets:

| Secret Name | Value |
|---|---|
| `SSH_HOST` | `dmozzakr.com` |
| `SSH_USER` | `dmozzjml` |
| `SSH_PRIVATE_KEY` | (Paste content from `~/.ssh/github_deploy`) |

### 2.3 Setup Git Repository on Server

Run on cPanel terminal:

```bash
cd ~/public_html/plantable

# Initialize git if not already done
git init
git remote add origin https://github.com/knowyourmediseo-cell/plantable.git

# Configure git user
git config user.email "deploybot@dmozzakr.com"
git config user.name "Deploy Bot"

# Fetch latest code
git fetch origin main
git checkout main
git pull origin main
```

---

## How It Works

1. **You push code to GitHub** → `git push origin main`
2. **GitHub Actions workflow triggers** (automatically)
3. **Workflow connects to your server via SSH**
4. **Runs deployment commands on server:**
   - Pulls latest code from GitHub
   - Installs composer dependencies
   - Clears old caches
   - Runs migrations if needed
   - Sets proper permissions

---

## Testing the Workflow

1. Make a small change to a file locally (e.g., add a comment in a controller)
2. Commit and push: `git add . && git commit -m "test deployment" && git push origin main`
3. Go to GitHub repo → Actions tab
4. Watch the workflow execute (should take 2-3 minutes)
5. Check your live website after it completes

---

## Manual Deployment Command (If Needed)

If you need to deploy without GitHub Actions, run on cPanel:

```bash
cd ~/public_html/plantable
git pull origin main
composer install --ignore-platform-reqs --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage/logs storage/framework/views storage/framework/cache
curl https://dmozzakr.com/plantable/  # Test it
```

---

## Troubleshooting

| Problem | Solution |
|---|---|
| Website still shows loader | Check: `tail -50 ~/public_html/plantable/storage/logs/laravel.log` |
| Deployment workflow fails | Check GitHub Actions logs → See what command failed |
| Permissions denied | Run: `chmod -R 777 ~/public_html/plantable/storage` |
| Git permission denied | Check SSH key is added to ~/.ssh/authorized_keys |

