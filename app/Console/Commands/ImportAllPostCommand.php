<?php
namespace App\Console\Commands;

use App\Components\ImportImage;
use App\Components\PostAdviceImport;
use App\Components\PostGuideImport;
use App\Components\PostMyBookImport;
use Illuminate\Console\Command;

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
                $posts         = $importer->getPosts(10, 1);
               // dd($posts);
                                        break;
            case '86':
                $importer      = new PostGuideImport();
                $this->category_name = 'guide';
                $posts         = $importer->getPosts(10, 2);
                break;
            case '3':
                $importer      = new PostMyBookImport();
                $this->category_name = 'mybook';
                $posts         = $importer->getPosts(3, 1);
                break;
         
        }

             foreach ($posts as $post) {
           // dump($post);
             $html = $post['content']['rendered'];
                $slug = $post['slug'];
           
            // Удаление лишних пробелов и переносов строк
            // $cleanedText = preg_replace('/\s+/', ' ', $html);
             $content     = $html;
            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
              $images       = new ImportImage();
            $result       = $images->imagesGetStore($content, $slug, $this->category_name);
            $content = $result['html'];
            dump($content);
            $images_array = $result['images_array'];
         //dd($images_array);
            $post_current = [
                 'content'     => $content,
                // 'category_id' => $category_id,
                'title'       => $post['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
            ];

            //сохраняем текущий пост в БД
            $importer->savePosts($post_current);

         
            //  Сохраняем пути изображений в БД
            $importer->saveImages($images_array);

        }
    }
}
