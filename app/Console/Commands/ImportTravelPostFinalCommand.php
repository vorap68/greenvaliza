<?php

namespace App\Console\Commands;

use App\Components\ImportImage;
use Illuminate\Console\Command;
use App\Components\PostTravelImport;
use App\Models\Posts\TravelTable;

//Для импорта финальных  постов категории Travel , которые являются производными меню-постов 
//и НЕ находятся на гл меню и НЕ они принадлежат категории travel
class ImportTravelPostFinalCommand extends Command
{
  //здесь category_id  - это term_id категории меню-поста, к которому будут привязаны импортируемые посты
    protected $signature = 'import:travelpostend {category_id }';

   protected $description = 'Скачиваем посты для  категории  travel для меню-поста (категория ???)';
 
    public function handle()
    {
          $category_id = $this->argument('category_id');

          // получаем ID travel_table по term_id категории
          $travel_table_id = TravelTable::where('term_id', $category_id)->value('id');
      
          $importer = new PostTravelImport();
             $posts = $importer->getPosts(3, 1, '', $category_id);  
       //dd($posts);
        foreach ($posts as $post) { 
           //dd($post);
            $content = $post['content']['rendered'];  
           
           // $description = strip_tags($post['excerpt']['rendered']);
            //$description = preg_replace('/\s+/', ' ', $description);
            $slug = $post['slug'];
            
            //  Импорт изображений и сохранение на диске
            $images       = new ImportImage();
            $result       = $images->imagesGetStore($content, $slug, 'travels/post'); 
            $images_array = $result['images_array']; 
            //dd($images_array);
            $content      = $result['html'];
            
            //dump($content);
           $post_current  = [
                'content'     => $content,
                'title'       => $post['title']['rendered'],
                'slug'        => $slug,
                'travel_table_id'   => $travel_table_id,
               'is_visual' => 1,
               
                
            ];
            $result[] = $post_current;

           //сохраняем текущий пост в БД
            $importer->savePosts($post_current);

          // //  Сохраняем пути изображений в БД
            $importer->saveImages($images_array);
          
     
        }
       // dd($result);
    }
}
