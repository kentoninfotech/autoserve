# URGENT: Quick Fix for Your Deployment

Your setup is:
- `/home/username/autoserve/` ← Laravel app
- `/home/username/public_html/` ← Website files (what visitors see)

**The problem:** App was trying to write to `/autoserve/public/images/` but the web server only has access to `/public_html/`

## Immediate Steps (Do These Now)

### Step 1: Update .env on Server

SSH or via file manager, edit `/home/username/autoserve/.env`:

```ini
APP_ENV=production
APP_DEBUG=false
```

**Save the file!**

### Step 2: Run Clearing Commands

Via SSH (if available):
```bash
cd /home/username/autoserve
php artisan cache:clear
php artisan config:clear  
php artisan view:clear
```

If no SSH, you can try accessing via web at:
```
https://autoserve.com.ng/artisan-cli  (if you have one set up)
```

### Step 3: Create Directories in public_html

Via FTP/File Manager, in `/home/username/public_html/`:

Create these folders:
- `images`
- `job_images`  
- `vehicle_images`
- `pdf`

Set each folder to permissions: **755**

### Step 4: Copy .htaccess Files

From `/home/username/autoserve/public/images/` copy `.htaccess` to `/home/username/public_html/images/`

Do the same for:
- `/autoserve/public/job_images/.htaccess` → `/public_html/job_images/.htaccess`
- `/autoserve/public/vehicle_images/.htaccess` → `/public_html/vehicle_images/.htaccess`
- `/autoserve/public/pdf/.htaccess` → `/public_html/pdf/.htaccess`

### Step 5: Test

1. Go to: `https://autoserve.com.ng/settings/update-account`
2. Upload a new logo image
3. Save settings
4. Check if the logo appears at: `https://autoserve.com.ng/images/` (should see your file)
5. If it appears, try uploading a job image too

## If Still Not Working

Run this via SSH:

```bash
cd /home/username/autoserve

# Check if files are actually in public_html
ls -la /home/username/public_html/images/

# Should show your uploaded files here!

# If not, check the Laravel log:
tail -50 storage/logs/laravel.log

# Look for any error messages about file permissions or directory creation
```

## What Changed in Code

- **New File:** `app/Providers/PublicPathServiceProvider.php`
  - Automatically redirects `public_path()` to `/public_html/` when in production

- **Updated:** `config/app.php`
  - Added the new provider to the providers list

- **Updated Controllers:**
  - All upload controllers now create directories with proper permissions
  - All now use `public_path()` correctly

## The New Flow

```
User uploads image
        ↓
Controller calls public_path('images')
        ↓
PublicPathServiceProvider says: "Use /public_html/"
        ↓
File saves to /public_html/images/filename.jpg
        ↓
Web server serves from https://autoserve.com.ng/images/filename.jpg
        ↓
.htaccess allows access to image files
        ↓
Image displays! ✓
```

## Did Code Get Pushed?

Make sure you did `git push origin` to send these changes to your server!

```bash
git add .
git commit -m "Fix image uploads for shared hosting with separate public_html"
git push origin
```

Then on server:

```bash
cd /home/username/autoserve
git pull origin
```

## Quick Verify Checklist

- [ ] `.env` has `APP_ENV=production`
- [ ] Cache cleared (`php artisan cache:clear`)
- [ ] Directories exist in `/public_html/images/`, `/public_html/job_images/`, etc.
- [ ] Directories set to permissions 755
- [ ] `.htaccess` files copied to each directory
- [ ] Latest code pulled from git
- [ ] Test upload works

If you've done all these and still have issues, post the error from `storage/logs/laravel.log`
