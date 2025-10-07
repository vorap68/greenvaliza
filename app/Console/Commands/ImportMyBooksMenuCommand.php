<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\ImportMenuMyBooks;

class ImportMyBooksMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mybooksmenu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import menu ya and moi knigi from greenvaliza';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
         $importer = new ImportMenuMyBooks();
        $posts    = $importer->getMyBooksMenu(100, 1);   

        //Здесь я вызываю сервис для изменения размера изображений  
        $dir = 'categoryMenu/'; // Путь к директории с категориями
        $folder = 'ya-i-moi-knigi/'; // Путь к директории с изображениями
        $imageService = new \App\Services\ImageService();
        $imageService->dirToName($dir, $folder);
    }
}
