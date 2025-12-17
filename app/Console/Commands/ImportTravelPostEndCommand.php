<?php

namespace App\Console\Commands;

use App\Components\ImportImage;
use Illuminate\Console\Command;
use App\Components\PostTravelImport;

class ImportTravelPostEndCommand extends Command
{
    protected $signature = 'import:travelpostend {category_id }';

   protected $description = 'Скачиваем посты для  категории  travel для меню-поста (категория ???)';
 

    /**
     * Execute the console command.
     */
    public function handle()
    {
          $category_id = $this->argument('category_id');
      
          $importer = new PostTravelImport();
             $posts = $importer->getPosts(10, 1,'post', $category_id); 
        dd($posts);
        
    
        foreach ($posts as $post) {
           //dd($post);
            $html = $post['content']['rendered'];
            // Извлечение текста из HTML
          //  $text = strip_tags($html);
            // Удаление лишних пробелов и переносов строк
           // $cleanedText = preg_replace('/\s+/', ' ', $html);
           // dd($cleanedText);
            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
           $content     = $html;
            $slug = $post['slug'];
            
            //  Импорт изображений и сохранение на диске
            $images       = new ImportImage();
            $result       = $images->imagesGetStore($content, $slug, 'travels');
            $images_array = $result['images_array']; 
            dump($images_array);
            $content      = $result['html'];
            dump($content);
            $is_published = $post['status'] === 'publish' ? 1 : 0;
           $post_current  = [
                'content'     => '',
                'title'       => $post['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'parent_id'   => $category_id,
               'is_published' => $is_published,
                'type'        => $is_acf,
                
            ];
            $result[] = $post_current;
            dd($post_current);
            //сохраняем текущий пост в БД
            $importer->savePosts($post_current);

          // //  Сохраняем пути изображений в БД
            $importer->saveImages($images_array);
          
     
        }
       // dd($result);
    }
}
