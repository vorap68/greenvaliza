<?php
namespace App\Console\Commands;

use App\Components\CreateNewPost;
use App\Components\ImportImage;
use App\Components\PostTravelImport;
use App\Models\Categories\TravelMenu;
use App\Models\Posts\TravelPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTravelPostMainCommand extends Command
{

    protected $signature = 'import:travelpostmain';

    protected $description = 'Скачиваем посты  категории travel из меню Мои Путеш. (категория 2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $importer   = new PostTravelImport();
        $postCreate = new CreateNewPost();
        $posts      = $importer->getPosts(10, 6, 'post', 2);
        //dd($posts);
        $result = [];
        foreach ($posts as $post) {
            //dd($post);
            $title   = $post['title']['rendered'];
            $content = $post['content']['rendered'];
            $slug    = $post['slug'];
            $menu_id = TravelMenu::where('slug', $slug)->get()->value('id');
            // Удаление лишних пробелов и переносов строк
            $cleanedText = preg_replace('/\s+/', ' ', $content);

            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);

            try {
                DB::beginTransaction();
                //создать новый пост чтоб уже оперировать с $post_id
                $newPost = $postCreate->createCurrent(
                    modelClass: TravelPost::class,
                    slug: $slug,
                    data: ['description' => $description ?? '',
                        'menu_id'            => $menu_id,
                        'title'              => $title,
                    ]);
                dd('Processing post: ' . $newPost);
                //  если пост уже был — ничего не делаем
                if (! $newPost->wasRecentlyCreated) {
                    DB::rollBack();
                    continue;
                }
                //  dd($post_current);
                $images  = new ImportImage();
                $result  = $images->imagesGetStore($content, $newPost->id, 'travelPost');
                $content = $result['html'];
                $result  = $newPost->update([
                    'content' => $content,
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            // dd($result);
        }

    }
}
