<?php

namespace App\Console\Commands;

use App\Services\ImageService;
use Illuminate\Console\Command;

class ImageResizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:resize {dir}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resizing images in the specified directory';

    /**
     * Execute the console command.
     */
    public function handle(ImageService $imageService)
    {
        $dir = $this->argument('dir');
      
        if (!$dir) {
            $this->error('Please provide a valid path using the --path option.');
            return 1;
        }

        $this->info("Starting image resizing in directory: {$dir}");
        new ImageService;
        
        $success = $imageService->dirToName( $dir);
        if (!$success) {
            $this->error("Failed to resize images in directory: {$dir}");
        
        $this->info("Image resizing completed in directory: {$dir}");
        return 0;
    }
}
}