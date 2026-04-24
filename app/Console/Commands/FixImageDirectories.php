<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\File;

class FixImageDirectories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:fix-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix image directory permissions and create missing directories for uploads';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fixing image directory permissions...');

        $directories = [
            public_path('images'),
            public_path('job_images'),
            public_path('vehicle_images'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("✓ Created directory: $directory");
            } else {
                $this->info("→ Directory exists: $directory");
            }

            // Set permissions
            @chmod($directory, 0755);
            $this->info("✓ Set permissions 755 for: $directory");
        }

        // Verify directories are writable
        $this->newLine();
        $this->info('Verifying directories are writable...');
        
        foreach ($directories as $directory) {
            if (is_writable($directory)) {
                $this->info("<fg=green>✓ Writable: $directory</>");
            } else {
                $this->error("✗ NOT WRITABLE: $directory");
                $this->error("Please contact your hosting provider to fix permissions");
            }
        }

        $this->newLine();
        $this->info('<fg=green>Image directories setup complete!</>');
        $this->info('Your images should now be accessible at:');
        $this->info('  - https://autoserve.com.ng/images/');
        $this->info('  - https://autoserve.com.ng/job_images/');
        $this->info('  - https://autoserve.com.ng/vehicle_images/');

        return Command::SUCCESS;
    }
}
