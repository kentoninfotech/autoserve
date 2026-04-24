# Autoserve - Hosting Provider Quick Reference

## For System Administrators / Hosting Support

### Issue
Uploaded images return 404 Not Found errors after Laravel app deployment.

Example: `https://autoserve.com.ng/images/2026_04_24_logo.jpg`

### Root Cause
Directory permissions or web server write access issues for public upload directories.

### Quick Fix

#### Via SSH (Recommended)

```bash
# Navigate to app root
cd /home/username/public_html/autoserve

# Run permission fix
php artisan images:fix-permissions

# Or manual fix:
mkdir -p public/{images,job_images,vehicle_images,pdf}
chmod 755 public/images public/job_images public/vehicle_images public/pdf
```

#### Via File Manager (cPanel, Plesk, etc.)

1. Create these folders in `public/`:
   - `images`
   - `job_images`
   - `vehicle_images`
   - `pdf`

2. Set permissions to `755` for each folder

#### Verify

```bash
# Check directory permissions (should be 755)
ls -la /home/username/public_html/autoserve/public/ | grep -E "images|job_images|vehicle_images|pdf"

# Check file permissions (should be 644)
ls -la /home/username/public_html/autoserve/public/images/

# Test web access
curl -I https://autoserve.com.ng/images/
```

### Requirements

1. **mod_rewrite**: Should be enabled (required for `.htaccess` support)
2. **Write Permissions**: PHP/web server must be able to write to `public/images/` etc.
3. **Directory Structure**: Already provided in codebase (`.htaccess` files included)

### What Application Does

- **Auto-creates** directories on first upload if missing
- **Auto-sets** permissions to 755 when uploading
- **Stores files** with names: `YYYY_MM_DD_timestamp_filename.ext`
- **Serves files** directly via web server (not through PHP)

### .htaccess Files

The application includes `.htaccess` in each image directory:
- `/public/images/.htaccess`
- `/public/job_images/.htaccess`
- `/public/vehicle_images/.htaccess`
- `/public/pdf/.htaccess`

These files:
- Allow direct file access (disable rewriting)
- Block hidden files
- Allow image and document files through

### Common Issues & Solutions

| Issue | Check | Solution |
|-------|-------|----------|
| 404 errors | `ls -la public/images/` | Run Artisan command or set 755 permissions |
| Files not upload | Check PHP error logs | Ensure write permissions, increase upload_max_filesize |
| .htaccess ignored | Apache modules | Enable `mod_rewrite`, allow `.htaccess` override |
| Slow uploads | Server config | Check with host for upload timeouts, memory limits |

### PHP Configuration (if needed)

```php
// In php.ini or .user.ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
memory_limit = 256M
```

### Contact Information

If issues persist, have customer provide:
1. Output of: `php artisan images:fix-permissions`
2. Output of: `ls -la /path/to/public/images/`
3. Error from: `tail -f storage/logs/laravel.log`
4. PHP error log entries related to uploads
