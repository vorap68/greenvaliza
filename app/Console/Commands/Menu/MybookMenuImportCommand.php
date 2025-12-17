<?php

namespace App\Console\Commands\Menu;

use Illuminate\Console\Command;
use App\Models\Categories\MyBook;
use App\Models\Categories\MyBookMenu;

class MybookMenuImportCommand extends Command
{
    use \App\Trait\CategoryImport; 

    protected $signature = 'import:mybookmenu';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->initClient();
        $posts = $this->getPosts(3, 100, 1); // категория sovety-i-poleznosti id=6
          foreach ($posts as $item) {
            //dd($item);
          $description = strip_tags($item['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
            $slug = $item['slug'];
             $imageUlr = $item['jetpack_featured_media_url'];
             $this->saveImages($imageUlr, $slug,'mybook');
             
            $item_current  = [
               'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName' => $this->imageName,
                'imageExten' => $this->imageExten
            ];

              MyBookMenu::create($item_current); // для путеводителей
          }
    }
}
