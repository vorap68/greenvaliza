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
        $posts = $this->getPosts(10, 1, 3); // категория myBook id=3 (perPage,Page, category_id)
          foreach ($posts as $item) {
           // dd($item);
          $description = strip_tags($item['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
            $slug = $item['slug'];
             $imageUlr = $item['jetpack_featured_media_url']; 
             $filename      = basename($imageUlr);
            $cleanFileName = explode('?', $filename)[0];
            $item_current  = [
                'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName'   => $cleanFileName,
            ];

            //dd($imageUlr);
            $post_id = MyBookMenu::firstOrCreate($item_current)->id; // для путеводителей
            $this->saveImages($imageUlr, $cleanFileName, $post_id, 'mybook'); 
           
        }
    }
}
