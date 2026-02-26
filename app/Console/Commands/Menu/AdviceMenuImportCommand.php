<?php
namespace App\Console\Commands\Menu;

use App\Models\Categories\AdviceMenu;
use Illuminate\Console\Command;

class AdviceMenuImportCommand extends Command
{
    use \App\Trait\CategoryImport;

    protected $signature = 'import:advicemenu';

    protected $description = 'Скачивает посты-категории советы и полезности ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->initClient();
        $posts = $this->getPosts(20, 1, 6); // категория sovety-i-poleznosti id=6 (perPage,Page, category_id)
       // dd($posts);
        foreach ($posts as $item) {
            // dd($item);
            $description   = strip_tags($item['excerpt']['rendered']); 
            $description   = preg_replace('/\s+/', ' ', $description);
            $slug          = $item['slug'];
            $imageUlr      = $item['jetpack_featured_media_url'];
            $filename      = basename($imageUlr);
            $cleanFileName = explode('?', $filename)[0];
            $item_current  = [
                'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName'   => $cleanFileName,
            ];
            $post_id = AdviceMenu::firstOrCreate($item_current)->id; // для путеводителей
            $this->saveImages($imageUlr, $cleanFileName, $post_id, 'advice');
           
        }
    }
}
