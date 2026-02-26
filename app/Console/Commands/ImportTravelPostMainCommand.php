<?php
namespace App\Console\Commands;

use App\Components\ImportImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Components\PostTravelImport;
use App\Models\Categories\TravelMenu;

class ImportTravelPostMainCommand extends Command
{

    protected $signature = 'import:travelpostmain'; 

    protected $description = 'Скачиваем посты  категории travel из меню Мои Путеш. (категория 2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $importer = new PostTravelImport();
        $posts    = $importer->getPosts(10, 6, 'post', 2); 
        //dd($posts);
        $result = [];
        foreach ($posts as $post) {
            //dd($post);
            $title   = $post['title']['rendered'];
            $content = $post['content']['rendered'];
            $slug    = $post['slug'];
            $menu_id = TravelMenu::where('slug',$slug)->get()->value('id');
            // Удаление лишних пробелов и переносов строк
            $cleanedText = preg_replace('/\s+/', ' ', $content);

            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);

            //  Импорт изображений и сохранение на диске
           
            try {
                DB::beginTransaction();
                //создать новый пост чтоб уже оперировать с $post_id
                $newPost = $importer->createPostCurrent(title:$title, slug:$slug, description:$description, menu_id:$menu_id);
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

    }
}
