<?php
namespace App\Console\Commands;

use App\Components\ImportImage;
use App\Components\PostTravelImport;
use Illuminate\Console\Command;
use InvalidArgumentException;

class ImportTravelPostMainCommand extends Command
{

    protected $signature = 'import:travelpostmenu {is_acf }';

    protected $description = 'Скачиваем посты для  категории  travel из меню (категория 2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $is_acf  = $this->argument('is_acf');
        $allowed = ['menu', 'post'];
        if (! in_array($is_acf, $allowed, true)) {
            throw new InvalidArgumentException(
                "Недопустимое значение '{$is_acf}'. Разрешено: " . implode(', ', $allowed)
            );
        }
        $importer = new PostTravelImport();
        $posts    = $importer->getPosts(2, 1, $is_acf);
       // dd($posts);
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
            $result       = $images->imagesGetStore($content, $slug, 'travels');
            $images_array = $result['images_array']; 
            dump($images_array);
            $content      = $result['html'];
           // dd($content);
            $is_published = $post['status'] === 'publish' ? 1 : 0;
            $parent_id    = null;
            $post_current = [
                'content'      => $content,
                'title'        => $post['title']['rendered'],
                'slug'         => $slug,
                'description'  => $description,
                'parent_id'    => $parent_id,
                'is_published' => $is_published,
                'type'         => $is_acf,

            ];

            // dump($post_current);

            $result[] = $post_current;
            //сохраняем текущий пост в БД
            $importer->savePosts($post_current);

            // //  Сохраняем пути изображений в БД
            $importer->saveImages($images_array);
        }
        // dd($result);
    }

}
