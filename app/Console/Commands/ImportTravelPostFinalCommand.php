<?php

namespace App\Console\Commands;

use App\Components\ImportImage;
use Illuminate\Console\Command;
use App\Models\Posts\TravelTable;
use Illuminate\Support\Facades\DB;
use App\Components\PostTravelImport;

//Для импорта финальных  постов категории Travel , которые являются производными меню-постов 
//и НЕ находятся на гл меню и НЕ они принадлежат категории travel
// Они должны быть связаны с постом table-post через menu_id и term_id 
class ImportTravelPostFinalCommand extends Command
{
  //здесь category_id  - это term_id категории меню-поста, к которому будут привязаны импортируемые посты
    protected $signature = 'import:travelpostend {category_id }';

   protected $description = 'Скачиваем посты для  категории  travel для меню-поста (категория ???)';
 
    public function handle()
    {
          $category_id = $this->argument('category_id');

          // нужно связать финал-пост с постом table-post 
          // все посты для данной  term_id  принадлежат  одному посту table-post
          // те это все посты из одной таблицы
          $table_id = TravelTable::where('term_id', $category_id)->value('id'); 
      
          $importer = new PostTravelImport();
             $posts = $importer->getPosts(10, 1, '', $category_id);  
      // dd($posts);
        foreach ($posts as $post) { 
         
            $title   = $post['title']['rendered'];
            $content = $post['content']['rendered'];
            $slug    = $post['slug'];
           
            
             try {
                DB::beginTransaction();
                //создать новый пост чтоб уже оперировать с $post_id
                $newPost = $importer->createPostCurrent(title:$title, slug:$slug, table_id:$table_id);
                dump('Processing post: ' . $newPost);
                //  если пост уже был — ничего не делаем
                if (! $newPost->wasRecentlyCreated) {
                    DB::rollBack();
                    continue;
                }
               

                //  dd($post_current);
            $images = new ImportImage();
            $result = $images->imagesGetStore($content, $newPost->id, 'travel/post');
            $images_array = $result['images_array'];
            // dump($images_array);
            $content = $result['html'];
               $result = $newPost->update([
                    'content' =>$content,
                ]);
              
                // //  Сохраняем пути изображений в БД
                $importer->saveImages($images_array);
            
             DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            // dd($result);
        }

       // dd($result);
    }
}
