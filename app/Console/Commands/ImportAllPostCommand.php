<?php
namespace App\Console\Commands;

use App\Components\CreateNewPost;
use App\Components\ImportImage;
use App\Components\PostAllImport;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use App\Models\Posts\MybookPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $importer    = new PostAllImport();
        $postCreate  = new CreateNewPost();
        $posts       = $importer-> getPosts(perPage: 10, page: 1,category_id:  $category_id);
        switch ($category_id) {
            case '6':
                $this->category_name = 'advice';
                $catClassName        = AdvicePost::class;
                $catMenuСlass       = AdviceMenu::class;
                break;
            case '86':
                $this->category_name = 'guide';
                $catClassName        = GuidePost::class;
                $catMenuСlass       = GuideMenu::class;
                break;
            case '3':
                $this->category_name = 'mybook';
                $catClassName        = MybookPost::class;
                $catMenuСlass       = MyBookMenu::class;
                break;
            }
            
       foreach ($posts as $post) {
            // dump($post);
            $title            = $post['title']['rendered'];
            $content          = $post['content']['rendered'];
            $slug             = $post['slug'];
            $category_menu_id = $catMenuСlass::where('slug', $slug)->value('id');

            // Удаление лишних пробелов и переносов строк
            $description = strip_tags($post['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);

            try {
                DB::beginTransaction();
                //создать новый пост чтоб уже оперировать с $post_id
                $newPost = $postCreate->createCurrent(
                    modelClass: $catClassName,
                    slug: $slug,
                    data: ['title'     => $title,
                        'description'      => $description ?? '',
                        'menu_id' => $category_menu_id,
                    ]);

                dump([
                    'model'              => $catClassName,
                    'post_id'            => $newPost->id,
                    'title'              => $newPost->title,
                    'slug'               => $newPost->slug,
                    'wasRecentlyCreated' => $newPost->wasRecentlyCreated,
                    'exists'             => $newPost->exists,
                ]);
//  DB::rollBack(); // <-- отменяем изменения вручную
                                //  если пост уже был — ничего не делаем
                if (! $newPost->wasRecentlyCreated) {
                    DB::rollBack();
                    continue;
                }

                $images       = new ImportImage();
                $result       = $images->imagesGetStore($content, $newPost->id, $this->category_name);
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
