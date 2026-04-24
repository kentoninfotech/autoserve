# Autoserve - Shared Hosting Deployment Guide

## Image Upload 404 Fix

If you're experiencing 404 errors when trying to access uploaded images on your shared hosting, follow these steps.

## Problem
After deployment to shared hosting, images uploaded to the site show as 404 errors:
- `https://autoserve.com.ng/images/2026_04_24_gintecLogo.jpg` → Not Found
- `https://autoserve.com.ng/job_images/...` → Not Found
- `https://autoserve.com.ng/vehicle_images/...` → Not Found

**Special Case: App and public_html in Different Locations**

If your deployment structure is:
```
/home/username/
├── autoserve/           ← Laravel app root
└── public_html/         ← Web root (what visitors see)
```

The app needs to be configured to write files to `/public_html/` instead of `/autoserve/public/`.

## Root Causes
1. Image directories don't exist in the web-accessible location
2. Directory permissions are incorrect (not writable)
3. App configured to write to wrong location (separate public_html)
4. Web server cannot write to public directories
5. .htaccess rules blocking access to image files

## Solution for Separate public_html

### What Was Changed in the Code

**New Service Provider:** `App\Providers\PublicPathServiceProvider`
- Automatically detects if `public_html` exists at parent directory level
- Redirects all `public_path()` calls to use `public_html` when in production
- Keeps local development unchanged

### Step 1: Deploy Code Changes

Push the latest code which includes:
- New `PublicPathServiceProvider` in `app/Providers/`
- Updated `config/app.php` (provider registered)
- Updated controllers with directory creation code

### Step 2: Set .env to Production

Ensure your `.env` file on the server has:
```ini
APP_ENV=production
APP_DEBUG=false
```

**Why?** The `PublicPathServiceProvider` only redirects to public_html when NOT in 'local' environment.

### Step 3: Run Setup (SSH Access Recommended)

**Option A - Automatic Setup Script:**

```bash
cd /home/username/autoserve
bash deploy-shared-hosting.sh
```

This will:
- Create all required directories in `public_html`
- Set permissions to 755
- Copy `.htaccess` files
- Clear Laravel cache
- Verify setup

**Option B - Manual Setup via FTP/File Manager:**

1. **Navigate to `/home/username/public_html/`**

2. **Create these directories:**
   - `images/`
   - `job_images/`
   - `vehicle_images/`
   - `pdf/`

3. **Set directory permissions to 755:**
   - Right-click → Properties
   - Set to `755` (or `rwxr-xr-x`)

4. **Upload these .htaccess files into each directory:**

   **images/.htaccess** - copy from `/autoserve/public/images/.htaccess`
   **job_images/.htaccess** - copy from `/autoserve/public/job_images/.htaccess`
   **vehicle_images/.htaccess** - copy from `/autoserve/public/vehicle_images/.htaccess`
   **pdf/.htaccess** - copy from `/autoserve/public/pdf/.htaccess`

### Step 4: Clear Cache

In SSH terminal (or via Artisan command if available):

```bash
cd /home/username/autoserve
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Or access via web:
```
https://autoserve.com.ng/artisan-cli  (if available)
```

### Step 5: Test Upload

1. Visit: `https://autoserve.com.ng/settings/update-account`
2. Upload a new logo image
3. Check if it appears at: `https://autoserve.com.ng/images/` (should see file listed)
4. Check the image URL works

## File Structure After Fix

On the server at `/home/username/`:

```
public_html/
├── .htaccess
├── index.php                    ← Copied from public/
├── images/                      (755 permissions) ← NEW
│   ├── .htaccess
│   ├── 2026_04_24_logo.png
│   └── 2026_04_24_header.jpg
├── job_images/                  (755 permissions) ← NEW
│   ├── .htaccess
│   └── [job folders with images]
├── vehicle_images/              (755 permissions) ← NEW
│   ├── .htaccess
│   └── [vehicle images]
├── pdf/                         (755 permissions) ← NEW
│   ├── .htaccess
│   └── [diagnosis PDFs]
├── assets/
├── css/
├── js/
└── ...

autoserve/
├── app/
├── bootstrap/
├── config/
├── public/                      ← NOT used for uploads anymore
│   ├── images/
│   │   └── .htaccess
│   ├── job_images/
│   │   └── .htaccess
│   ├── vehicle_images/
│   │   └── .htaccess
│   ├── pdf/
│   │   └── .htaccess
│   └── [other files]
├── routes/
├── storage/
├── vendor/
└── ... other app files
```

## How It Works

1. **User uploads image** → SettingsController/JobsController/etc.

2. **Controller calls** `public_path('images')`

3. **PublicPathServiceProvider intercepts** and:
   - Checks if `/home/username/public_html` exists
   - If yes (production) → Returns `/home/username/public_html`
   - If no (local dev) → Returns `/home/username/autoserve/public`

4. **File is written** to `/public_html/images/filename.jpg`

5. **Web server serves** from `https://autoserve.com.ng/images/filename.jpg`

6. **.htaccess allows access** to image files directly

## Troubleshooting

### Still 404 After Changes?

1. **Verify files are in public_html:**
   ```bash
   ls -la /home/username/public_html/images/
   ```
   Should show files you uploaded.

2. **Check directory permissions:**
   ```bash
   ls -la /home/username/public_html/ | grep -E "images|job_images|vehicle_images|pdf"
   ```
   Should show: `drwxr-xr-x` (755)

3. **Verify .env is set to production:**
   ```bash
   grep APP_ENV /home/username/autoserve/.env
   ```
   Should output: `APP_ENV=production`

4. **Clear cache multiple times:**
   ```bash
   php artisan cache:clear
   php artisan config:clear  
   php artisan view:clear
   rm -rf /home/username/autoserve/bootstrap/cache/*
   ```

5. **Check PHP error logs:**
   ```bash
   tail -50 /home/username/public_html/../public_html_logs/error.log
   ```
   Or check cPanel Error Logs

### Files Still Not Uploading?

- Permissions not 755 on directories
- PHP user doesn't have write access
- Upload size limits exceeded
- Disk space full

Contact hosting provider and ask them to verify:
- PHP can write to `/home/username/public_html/`
- Set dir permissions to 755
- Check `upload_max_filesize` and `post_max_size` in php.ini

### .htaccess Not Working?

- mod_rewrite may not be enabled
- .htaccess overrides may be disabled
- Ask hosting to enable: `AllowOverride All` in Apache config

## URLs After Fix

Your images will now be accessible at:

- Company Logo/Header: `https://autoserve.com.ng/images/YYYY_MM_DD_filename.jpg`
- Job Images: `https://autoserve.com.ng/job_images/jobno/jobno_YYYY_MM_DD_index_filename.jpg`
- Vehicle Images: `https://autoserve.com.ng/vehicle_images/filename.jpg`
- Diagnosis PDFs: `https://autoserve.com.ng/pdf/timestamp_filename.pdf`

## Testing

Test the complete flow:

```bash
# SSH into server
ssh username@autoserve.com.ng

# Navigate to app
cd ~/autoserve

# Create test file
echo "test" > ~/public_html/test.txt
chmod 644 ~/public_html/test.txt

# Test from browser
curl https://autoserve.com.ng/test.txt
# Should output: test

# If that works, try uploading a real image in the app
```

## Need Help?

If issues persist:

1. Run: `php artisan images:fix-permissions`
2. Check: `storage/logs/laravel.log` for errors
3. Verify: `APP_URL=https://autoserve.com.ng` in `.env`
4. Contact hosting and share:
   - Output of `ls -la /home/username/public_html/images/`
   - Last 50 lines of error.log
   - PHP version info

