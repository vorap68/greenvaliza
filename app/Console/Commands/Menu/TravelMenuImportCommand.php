<?php

namespace App\Console\Commands\Menu;

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
        $posts = $this->getPosts(10, 6, 2); // категория travel id=2(perPage,Page, category_id)
        //dd($posts);
                foreach ($posts as $post) {
          $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description); 
            $slug = $post['slug'];
             $imageUlr = $post['jetpack_featured_media_url'];
               $filename      = basename($imageUlr);
            $cleanFileName = explode('?', $filename)[0];
             $type = empty($post['acf']) ? 'post' : 'tble';
            $post_current  = [
                'title'       => $post['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName'   => $cleanFileName,
                'type' => $type,
            ];
          // dd($post_current);
            $post_id = TravelMenu::firstOrCreate($post_current)->id; // для путеводителей
            $this->saveImages($imageUlr, $cleanFileName, $post_id, 'travel');
           
        }
           
          }
         
    
}
