<?php
namespace App\Console\Commands;

use App\Components\ImportImage;
use Illuminate\Console\Command;
use App\Components\TablePostImport;
use Illuminate\Support\Facades\DB;
use App\Models\Categories\TravelMenu;

class ImportTravelTableCommand extends Command
{

    protected $signature = 'import:traveltable';

    protected $description = 'Скачиваем посты-таблицы категории travel из меню Мои Путеш. (категория 2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $importer = new TablePostImport();
        $is_acf   = 'table'; // для скачив таблиц
        $posts    = $importer->getPosts(10, 7, $is_acf, 2);
        // dd($posts);
        $result = [];
        foreach ($posts as $post) {
            //dd($post);
            $title         = $post['title']['rendered'];
            $html          = $post['content']['rendered'];
            $slug          = $post['slug'];
            $table_menu_id = TravelMenu::where('slug', $slug)->value('id');
            // Удаление лишних пробелов и переносов строк
            $cleanedText = preg_replace('/\s+/', ' ', $html);
            // $content     = $cleanedText;

            try {
                DB::beginTransaction();
                //создать новый пост
                $newPost = $importer->createPostCurrent($title, $slug, $table_menu_id);
                dump('Processing post: ' . $newPost);
                //  если пост уже был — ничего не делаем
                if (! $newPost->wasRecentlyCreated) {
                    DB::rollBack();
                    continue;
                }
                $images       = new ImportImage();
                $result       = $images->imagesGetStore($html, $newPost->id, 'travel/table');
                $content      = $result['html'];
                $images_array = $result['images_array'];
                dump('Imported images: ', $images_array);
                $result = $newPost->update([
                    'content' => $content,
                ]);

                //  Сохраняем пути изображений в БД
                // $importer->saveImages($images_array);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        }
    }

}
