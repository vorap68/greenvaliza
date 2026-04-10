<?php
namespace App\Console\Commands;

use App\Components\CreateNewPost;
use App\Components\ImportImage;
use App\Components\TravelPostTableImport;
use App\Models\Categories\TravelMenu;
use App\Models\Posts\TravelTable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTravelTableCommand extends Command
{

    protected $signature = 'import:traveltable';

    protected $description = 'Скачиваем посты-таблицы категории travel из меню Мои Путеш. (категория 2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postCreate = new CreateNewPost();
        $importer   = new TravelPostTableImport();
        $is_acf     = 'table'; // для скачив таблиц
        $posts      =  $importer->getPosts(perPage:10, page:6 , is_acf: $is_acf , category_id: 2);
        
        $result = [];
        //dd('Посты для импорта', $posts);
        foreach ($posts as $post) {
            //dd($post);
            $title   = $post['title']['rendered'];
            $html    = $post['content']['rendered'];
            $slug    = $post['slug'];
            $menu_id = TravelMenu::where('slug', $slug)->value('id');

            try {
                DB::beginTransaction();
                //создать новый пост
                $newPost = $postCreate->createCurrent(
                    modelClass: TravelTable::class,
                    slug: $slug,
                    data: ['menu_id' => $menu_id,
                        'title'          => $title,
                    ]);
                dump('Processing post: ' . $newPost);
                //  если пост уже был — ничего не делаем

                //!!!!!!!!!!!!!!!!!!!!!!!!!!
                if (! $newPost->wasRecentlyCreated) {
                    DB::rollBack();
                    continue;
                }
                //!!!!!!!!!!!!!!!!!!!!!
                $images       = new ImportImage();
                $result       = $images->imagesGetStore($html, $newPost->id, 'travel/table');
                $content      = $result['html'];
                $result = $newPost->update([
                    'content' => $content,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        }
    }

}
