<?php
namespace App\Console\Commands;

use App\Services\ImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImageResizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:resize {folder}';

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
        $folder = $this->argument('folder');
        //dd($dir);

        if (! $folder) {
            $this->error('Please provide a valid path using the --path option.');
            return 1;
        }

        $this->info("Starting image resizing in directory: {$folder}");
        //new ImageService;

        $success = $this->dirToName($folder,$imageService);
      
    }


    //метод получения всех файлов(путей к файлам) в данной папке folder
    public function dirToName(string $folder, ImageService $imageService)
    {
        $dir = Storage::disk('public')->path('/images/' . $folder);
        // dump('Папка для обхода всех файлов в директории и поддиректориях', $dir);

        // Рекурсивный итератор для обхода всех файлов в директории и поддиректориях
        $rii = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
        );

        $fileNameArray = [];
        foreach ($rii as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isDir()) {
                continue;
            }
            $path = $file->getPathname();
            // ✅ Берём только файлы из папки original
            if (! str_contains($path, DIRECTORY_SEPARATOR . 'original' . DIRECTORY_SEPARATOR)) {
                continue;
            }

            $fileNameArray[] = $path;
        }
        //dd($fileNameArray);

        //если нужно то удаляем стар папку resize
        if (Storage::disk('public')->exists('/images/' . $folder . '/resize')) {
            Storage::disk('public')->deleteDirectory('/images/' . $folder . '/resize');

        }
         $imageService->saveResizedImages($fileNameArray);
       
    }

}
