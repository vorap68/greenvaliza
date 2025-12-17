<?php

namespace App\Console\Commands\Menu;

use App\Models\Categories\Travel;
use App\Models\Categories\TravelMenu;
use Illuminate\Console\Command;

class TravelMenuImportCommand extends Command
{
   use \App\Trait\CategoryImport;

    protected $signature = 'import:travelmenu';

  
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $this->initClient();
        $posts = $this->getPosts(2, 100, 1); // категория travel id=2
       // dd($posts);
                foreach ($posts as $item) {
          $description = strip_tags($item['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
            $slug = $item['slug'];
             $imageUlr = $item['jetpack_featured_media_url'];
             $this->saveImages($imageUlr, $slug,'travel');
             $type = empty($item['acf']) ? 'posts' : 'menus';
           
            $item_current  = [
               'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName' => $this->imageName,
                'imageExten' => $this->imageExten,
                  'type' => $type,
            ];
          
            $array_posts[] = $item_current;
              TravelMenu::create($item_current); // для путеводителей
          }
         
    }
}
