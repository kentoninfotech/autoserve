<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class ImageHelper
{
    /**
     * Ensure image directories exist and are writable
     */
    public static function ensureImageDirectoriesExist()
    {
        $directories = [
            public_path('images'),
            public_path('job_images'),
            public_path('vehicle_images'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            
            // Ensure directory is writable
            if (!is_writable($directory)) {
                @chmod($directory, 0755);
            }
        }
    }

    /**
     * Get the URL for an image file
     * Handles both absolute and relative paths
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }

        // If it already starts with /, return as-is with asset()
        if (strpos($imagePath, '/') === 0) {
            return asset($imagePath);
        }

        // Otherwise prepend / and use asset()
        return asset('/' . ltrim($imagePath, '/'));
    }

    /**
     * Create a subdirectory under images with proper permissions
     */
    public static function createImageSubdirectory($subdirName)
    {
        $path = public_path("images/{$subdirName}");
        
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        
        if (!is_writable($path)) {
            @chmod($path, 0755);
        }
        
        return $path;
    }
}
