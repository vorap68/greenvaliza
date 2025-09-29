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
    protected $signature = 'image:resize {--dir=}';

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
        $dir = $this->option('dir');

        if (!$dir) {
            $this->error('Please provide a valid path using the --path option.');
            return 1;
        }

        $this->info("Starting image resizing in directory: {$dir}");
        new ImageService;
        
        $success = $imageService->dirToName($dir);
        
        // Here you would add the logic to resize images in the specified directory.
        // This is a placeholder for demonstration purposes.
        // For example, you might use the Intervention Image library to handle image resizing.

        $this->info("Image resizing completed in directory: {$dir}");
        return 0;
    }
}
