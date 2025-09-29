<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\ImportMenuTravels;

class ImportTravelsMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'import:travelmenu';

    /**
     * The console command description.
     *
     * @var string
     */
  protected $description = 'Import menu nash-puteshestvi from greenvaliza';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $importer = new ImportMenuTravels();
             $posts    = $importer->getTravelsMenu(100, 1);   
         
        //Здесь я вызываю сервис для изменения размера изображений  
        $folder1 = 'categoryMenu/'; // Путь к директории с категориями
        $folder2 = 'nashi-puteshestviya/'; // Путь к директории с изображениями
        $imageService = new \App\Services\ImageService();
        $imageService->dirToName($folder1, $folder2);
       
    }
}
