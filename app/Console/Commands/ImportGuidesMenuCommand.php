<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\ImportMenuGuides;

class ImportGuidesMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:guidesmenu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import menu putevoditeli from greenvaliza';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $importer = new ImportMenuGuides();
        $posts    = $importer->getGuidesMenu(100, 1);   

        //Здесь я вызываю сервис для изменения размера изображений  
        $dir = 'categoryMenu/'; // Путь к директории с категориями
        $folder = 'putevoditeli/'; // Путь к директории с изображениями
        $imageService = new \App\Services\ImageService();
        $imageService->dirToName($dir, $folder);
    }
}
