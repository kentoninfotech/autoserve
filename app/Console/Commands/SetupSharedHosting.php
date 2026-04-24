<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupSharedHosting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hosting:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup all required directories for shared hosting deployment with separate public_html';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Setting up shared hosting directories...');
        $this->newLine();

        // Get paths
        $appRoot = base_path();
        $parentDir = dirname($appRoot);
        $publicHtmlPath = $parentDir . DIRECTORY_SEPARATOR . 'public_html';

        $this->info("App Root: $appRoot");
        $this->info("Public HTML: $publicHtmlPath");
        $this->newLine();

        // Check if public_html exists
        if (!is_dir($publicHtmlPath)) {
            $this->error("ERROR: public_html not found at $publicHtmlPath");
            $this->error("Please ensure the directory exists before running this command.");
            return 1;
        }

        $this->info("✓ public_html directory found");
        $this->newLine();

        // List of directories to create in public_html
        $directories = [
            'images',
            'job_images',
            'vehicle_images',
            'pdf',
            'assets',
        ];

        $this->info('Creating directories...');
        foreach ($directories as $dir) {
            $fullPath = $publicHtmlPath . DIRECTORY_SEPARATOR . $dir;
            
            if (!is_dir($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
                $this->line("  ✓ Created: $dir");
            } else {
                $this->line("  → Exists: $dir");
            }
            
            // Set permissions
            @chmod($fullPath, 0755);
        }

        $this->newLine();
        $this->info('Copying .htaccess files...');
        
        // Copy .htaccess files
        $htaccessDirs = [
            'images',
            'job_images',
            'vehicle_images',
            'pdf',
        ];
        
        foreach ($htaccessDirs as $dir) {
            $source = base_path("public/$dir/.htaccess");
            $dest = $publicHtmlPath . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . '.htaccess';
            
            if (file_exists($source)) {
                copy($source, $dest);
                $this->line("  ✓ Copied .htaccess to $dir/");
            }
        }

        $this->newLine();
        $this->info('Copying existing files from public/ to public_html/...');
        
        // Copy existing files from public to public_html
        $copyDirs = ['images', 'job_images', 'vehicle_images'];
        
        foreach ($copyDirs as $dir) {
            $source = base_path("public/$dir");
            $dest = $publicHtmlPath . DIRECTORY_SEPARATOR . $dir;
            
            if (is_dir($source) && count(glob("$source/*")) > 0) {
                shell_exec("cp -r $source/* $dest/ 2>/dev/null || true");
                $this->line("  ✓ Copied files from $dir/");
            }
        }

        $this->newLine();
        $this->info('Verifying directory permissions...');
        
        foreach ($directories as $dir) {
            $fullPath = $publicHtmlPath . DIRECTORY_SEPARATOR . $dir;
            $perms = fileperms($fullPath);
            $permsStr = substr(sprintf('%o', $perms), -3);
            
            if ($permsStr === '755') {
                $this->line("  <fg=green>✓ $dir - 755 (correct)</>");
            } else {
                $this->line("  <fg=yellow>! $dir - $permsStr (should be 755)</>");
            }
        }

        $this->newLine();
        $this->info('Clearing Laravel cache...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');

        $this->newLine();
        $this->info('<fg=green>✓ Setup complete!</>');
        $this->newLine();
        
        $this->info('Your images will now be accessible at:');
        $this->info('  • https://autoserve.com.ng/images/');
        $this->info('  • https://autoserve.com.ng/job_images/');
        $this->info('  • https://autoserve.com.ng/vehicle_images/');
        $this->info('  • https://autoserve.com.ng/pdf/');

        return 0;
    }
}
