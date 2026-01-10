<?php
namespace App\Console\Commands;

use App\Components\ImportImage;
use App\Components\PostTravelImport;
use Illuminate\Console\Command;
use InvalidArgumentException;

class ImportTravelPostMainCommand extends Command
{

    protected $signature = 'import:travelpostmenu ';

    protected $description = 'Скачиваем посты  категории travel из меню Мои Путеш. (категория 2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       
        $importer = new PostTravelImport();
        $posts    = $importer->getPosts(10, 6 ,'post', 2);
       //dd($posts);
        $result = [];
        foreach ($posts as $post) {
            //dd($post);
            $html = $post['content']['rendered'];
            $slug = $post['slug'];
            // Удаление лишних пробелов и переносов строк
            $cleanedText = preg_replace('/\s+/', ' ', $html);
           // $content     = $cleanedText;
            $content     = $html;
            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);

            //  Импорт изображений и сохранение на диске
            $images       = new ImportImage();
            $result       = $images->imagesGetStore($content, $slug, 'travels/post');
            $images_array = $result['images_array']; 
           // dump($images_array);
            $content      = $result['html'];
           // dd($content);
          
            $post_current = [
                'content'      => $content,
                'title'        => $post['title']['rendered'],
                'slug'         => $slug,
                'description'  => $description,
                'is_visual' => 1,

            ];

            //  dd($post_current);

            $result[] = $post_current;
            //сохраняем текущий пост в БД
            $importer->savePosts($post_current);

            // //  Сохраняем пути изображений в БД 
            $importer->saveImages($images_array);
        }
        // dd($result);
    }

}
