<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PublicPathServiceProvider extends ServiceProvider
{
    /**
     * Override the public path for the application.
     * This is needed when Laravel app is in a different directory than public_html
     * 
     * Deployment structure:
     * /home/username/autoserve/          <- Laravel app
     * /home/username/public_html/        <- Web root (where public files should go)
     */
    public function register()
    {
        // Check if we have a custom public path in env
        $publicPath = $this->app->basePath() . DIRECTORY_SEPARATOR . 'public';
        
        // If deployed on shared hosting with separate public_html
        // The public_html should be at the same level as the app root
        $parentPath = dirname($this->app->basePath());
        $publicHtmlPath = $parentPath . DIRECTORY_SEPARATOR . 'public_html';
        
        // Use public_html if it exists and we're not in local development
        if (is_dir($publicHtmlPath) && !$this->app->environment('local')) {
            $publicPath = $publicHtmlPath;
        }
        
        $this->app->bind('path.public', function () use ($publicPath) {
            return $publicPath;
        });
    }
}
