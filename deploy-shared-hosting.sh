#!/bin/bash

# Autoserve Shared Hosting Deployment Fix Script
# This script fixes the deployment structure for Laravel apps with separate public_html

echo "=========================================="
echo "Autoserve Shared Hosting Setup"
echo "=========================================="

# Get the current directory (should be autoserve root)
APP_ROOT=$(pwd)
APP_NAME=$(basename "$APP_ROOT")

echo ""
echo "App Root: $APP_ROOT"
echo ""

# Get parent directory
PARENT_DIR=$(dirname "$APP_ROOT")
PUBLIC_HTML="$PARENT_DIR/public_html"

echo "Looking for public_html at: $PUBLIC_HTML"

# Check if public_html exists
if [ ! -d "$PUBLIC_HTML" ]; then
    echo "ERROR: public_html not found at $PUBLIC_HTML"
    echo "Please ensure public_html exists at the same level as the app root"
    exit 1
fi

echo "✓ public_html found"
echo ""

# Create required directories in public_html
echo "Creating required directories..."
mkdir -p "$PUBLIC_HTML/images"
mkdir -p "$PUBLIC_HTML/job_images"
mkdir -p "$PUBLIC_HTML/vehicle_images"
mkdir -p "$PUBLIC_HTML/pdf"
mkdir -p "$PUBLIC_HTML/assets"

chmod 755 "$PUBLIC_HTML/images"
chmod 755 "$PUBLIC_HTML/job_images"
chmod 755 "$PUBLIC_HTML/vehicle_images"
chmod 755 "$PUBLIC_HTML/pdf"
chmod 755 "$PUBLIC_HTML/assets"

echo "✓ Directories created with proper permissions"
echo ""

# Copy .htaccess files to public_html
echo "Copying .htaccess protection files..."
cp "$APP_ROOT/public/images/.htaccess" "$PUBLIC_HTML/images/.htaccess" 2>/dev/null || true
cp "$APP_ROOT/public/job_images/.htaccess" "$PUBLIC_HTML/job_images/.htaccess" 2>/dev/null || true
cp "$APP_ROOT/public/vehicle_images/.htaccess" "$PUBLIC_HTML/vehicle_images/.htaccess" 2>/dev/null || true
cp "$APP_ROOT/public/pdf/.htaccess" "$PUBLIC_HTML/pdf/.htaccess" 2>/dev/null || true

echo "✓ .htaccess files copied"
echo ""

# Clear Laravel cache
echo "Clearing Laravel cache..."
cd "$APP_ROOT"
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "✓ Cache cleared"
echo ""

echo "=========================================="
echo "Setup Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Verify .env has: APP_ENV=production"
echo "2. Visit: https://autoserve.com.ng/settings/update-account"
echo "3. Upload a new logo to test"
echo "4. Check if image appears at: https://autoserve.com.ng/images/"
echo ""
