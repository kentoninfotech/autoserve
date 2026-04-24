# Autoserve - Shared Hosting Deployment Guide

## Image Upload 404 Fix

If you're experiencing 404 errors when trying to access uploaded images on your shared hosting, follow these steps.

## Problem
After deployment to shared hosting, images uploaded to the site show as 404 errors:
- `https://autoserve.com.ng/images/2026_04_24_gintecLogo.jpg` → Not Found
- `https://autoserve.com.ng/job_images/...` → Not Found
- `https://autoserve.com.ng/vehicle_images/...` → Not Found

## Root Causes
1. Image directories don't exist on the server
2. Directory permissions are incorrect (not writable)
3. .htaccess rules blocking access to image files
4. Web server cannot write to public directories

## Solution

### Step 1: Run the Fix Command (SSH Access Required)

Connect to your server via SSH and navigate to your application root:

```bash
cd /path/to/autoserve
php artisan images:fix-permissions
```

This command will:
- Create all image directories if they don't exist
- Set proper permissions (755) on all directories
- Verify directories are writable
- Show you the accessible URLs

### Step 2: Manual Fix (No SSH Access)

If you don't have SSH access, use FTP/File Manager:

1. **Create these directories in your `public/` folder:**
   - `images/`
   - `job_images/`
   - `vehicle_images/`
   - `pdf/`

2. **Set permissions to 755 for each directory:**
   - Right-click → Properties/Permissions
   - Set to `755` (or `rwxr-xr-x`)

3. **.htaccess files are already included** - they allow image access and disable rewriting for image directories

### Step 3: Verify the Fix

1. Upload a new logo or header image in Settings
2. Upload a vehicle image
3. Upload job images with a new job
4. Check the URLs:
   - Visit `https://autoserve.com.ng/images/` - should show directory listing or confirm directory exists
   - Visit `https://autoserve.com.ng/job_images/` - same check
   - Visit `https://autoserve.com.ng/vehicle_images/` - same check

## File Structure After Fix

Your `public/` directory should have:

```
public/
├── images/                  (755 permissions)
│   ├── .htaccess
│   ├── 2026_04_24_logo.png
│   └── 2026_04_24_header.jpg
├── job_images/              (755 permissions)
│   ├── .htaccess
│   ├── 1/
│   │   ├── images...
│   └── 2/
│       ├── images...
├── vehicle_images/          (755 permissions)
│   ├── .htaccess
│   └── car_images...
├── pdf/                     (755 permissions)
│   ├── .htaccess
│   └── diagnosis_files...
├── index.php
└── ... other files
```

## Troubleshooting

### Still Getting 404 Errors?

1. **Check file permissions are 755 (readable by web server)**
   ```bash
   ls -la /path/to/public/images/
   # Should show drwxr-xr-x (755)
   ```

2. **Check files are 644 (readable by web server)**
   ```bash
   ls -la /path/to/public/images/*.jpg
   # Should show -rw-r--r-- (644)
   ```

3. **Verify mod_rewrite is enabled**
   - Ask your hosting provider if `mod_rewrite` is enabled
   - Check if `.htaccess` files are being processed

4. **Check PHP file permissions**
   - PHP-FPM might run as a different user than the web server
   - Ask your hosting to ensure PHP can write to `public/images/`

### Still Not Working?

Contact your hosting provider and ask them to:
1. Ensure PHP/web server can write to `public/images/`, `public/job_images/`, `public/vehicle_images/`, and `public/pdf/`
2. Set permissions to at least `755` for directories and `644` for files
3. Verify `mod_rewrite` is enabled (for .htaccess support)
4. Check if there are any security restrictions preventing file uploads

## Automatic Directory Creation

The application now automatically creates directories when files are uploaded. However:

- **First deployment**: Run `php artisan images:fix-permissions` to set up all directories
- **Subsequent uploads**: Directories are created automatically with proper permissions
- **Manual uploads via FTP**: Create directories and set 755 permissions

## URLs After Fix

Your images will be accessible at:

- Company Logo/Header: `https://autoserve.com.ng/images/YYYY_MM_DD_filename.jpg`
- Job Images: `https://autoserve.com.ng/job_images/jobno/jobno_YYYY_MM_DD_index_filename.jpg`
- Vehicle Images: `https://autoserve.com.ng/vehicle_images/filename.jpg`
- Diagnosis PDFs: `https://autoserve.com.ng/pdf/timestamp_filename.pdf`

## Testing

Test your uploads:

```bash
# SSH into server
cd /path/to/autoserve

# Create test directory
mkdir -p public/test_images
chmod 755 public/test_images

# Create test file
echo "test" > public/test_images/test.txt
chmod 644 public/test_images/test.txt

# Check it's accessible
curl https://autoserve.com.ng/test_images/test.txt

# Should output: test
```

If the test works but images still show 404, the issue may be with how files are being named or stored in your controllers.

## Need Help?

If problems persist:
1. Run: `php artisan storage:link` (for storage disk compatibility)
2. Check `storage/logs/laravel.log` for error messages
3. Verify `.env` has correct `APP_URL=https://autoserve.com.ng`
4. Clear cache: `php artisan cache:clear && php artisan config:clear`
