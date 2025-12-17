<?php

namespace App\Console\Commands\Menu;

use App\Models\Categories\Guide;
use App\Models\Categories\GuidebookMenu;
use App\Models\Categories\GuideMenu;
use Illuminate\Console\Command;

class GuideMenuImportCommand extends Command
{
  
    use \App\Trait\CategoryImport; 

    protected $signature = 'import:guidemenu';

 
    protected $description = 'Скачивает посты-категории путеводители';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        $this->initClient();
        $posts = $this->getPosts(86, 100, 1); // категория sovety-i-poleznosti id=6
          foreach ($posts as $item) {
            //dd($item);
          $description = strip_tags($item['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
            $slug = $item['slug'];
             $imageUlr = $item['jetpack_featured_media_url'];
             $this->saveImages($imageUlr, $slug,'guide');
             
            $item_current  = [
               'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName' => $this->imageName,
                'imageExten' => $this->imageExten
            ];

             GuideMenu::create($item_current); // для путеводителей
          }
    }
}
