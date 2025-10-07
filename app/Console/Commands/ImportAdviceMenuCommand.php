<?php

namespace App\Console\Commands;

use App\Components\ImportMenuAdvices;
use Illuminate\Console\Command;

class ImportAdviceMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:advicemenu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import menu sovety and poleznosti from greenvaliza';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $importer = new ImportMenuAdvices();
        $posts    = $importer->getAdviceMenu(100, 1);   

        //Здесь я вызываю сервис для изменения размера изображений  
        $dir = 'categoryMenu/'; // Путь к директории с категориями
        $folder = 'sovety-i-poleznosti/'; // Путь к директории с изображениями
        $imageService = new \App\Services\ImageService();
        $imageService->dirToName($dir, $folder);
    }
}
