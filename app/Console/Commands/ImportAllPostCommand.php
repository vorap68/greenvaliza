<?php
namespace App\Console\Commands;

use App\Components\ImportImage;
use Illuminate\Console\Command;
use App\Models\Posts\AdvicePost;
use Illuminate\Support\Facades\DB;
use App\Components\PostGuideImport;
use App\Components\PostMyBookImport;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\MyBookMenu;
use App\Components\PostAdviceImport;         

//Для импорта конечных постов всех категорий (кроме Travel)
class ImportAllPostCommand extends Command
{
    public $category_name;
    protected $signature = 'import:post {category_id}';

    protected $description = 'Скачиваем посты для всех категорий КРОМЕ!!!!! travel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $category_id = $this->argument('category_id'); 
        switch ($category_id) {

            case '6':
                $importer      = new PostAdviceImport();
                $this->category_name = 'advice';
                $catMenuСlass = AdviceMenu::class;
                $posts         = $importer->getPosts(10, 2); 
               // dd($posts);
                                        break;
            case '86':
                $importer      = new PostGuideImport();
                $this->category_name = 'guide';
                $catMenuСlass = GuideMenu::class;
                $posts         = $importer->getPosts(10, 1);
                break;
            case '3':
                $importer      = new PostMyBookImport();
                $this->category_name = 'mybook';
                $catMenuСlass = MyBookMenu::class;
                $posts         = $importer->getPosts(3, 1);
                break;
         
        }
           // dd($posts);
             foreach ($posts as $post) {
           // dump($post);
            $title = $post['title']['rendered'];
             $html = $post['content']['rendered'];
                $slug = $post['slug'];
                $category_menu_id = $catMenuСlass::where('slug', $slug)->value('id');
         
            // Удаление лишних пробелов и переносов строк
            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);

            try{
                DB::beginTransaction();
            //создать новый пост
            $newPost = $importer->createPostCurrent($title, $slug, $description, $category_menu_id);
            dump('Processing post: ' . $newPost );
   //  если пост уже был — ничего не делаем
        if (! $newPost->wasRecentlyCreated) {
            DB::rollBack();
            continue;
        }
            $images = new ImportImage();
            $result = $images->imagesGetStore($html, $newPost->id, $this->category_name);
            $content = $result['html'];
            $images_array = $result['images_array'];
                dump('Imported images: ' , $images_array);
                $result = $newPost->update([
                    'content' =>$content,
                ]);
         
            //  Сохраняем пути изображений в БД
           $importer->saveImages($images_array);
            DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
           

        }
    }
}
