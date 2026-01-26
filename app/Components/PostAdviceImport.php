<?php
namespace App\Components;

use App\Models\Images\AdvicePostImage;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class PostAdviceImport 
{
    public $client;
    protected $post_id;

    public function __construct() 
    {
        $this->client = new Client([
            'base_uri' => 'https://greenvaliza.co.ua/wp-json/wp/v2/', 
            'timeout'  => 10.0,
        ]);
    }

    /**
     * Получить посты
     */
    public function getPosts($perPage = 1, $page = 1) 
    {

        $response = $this->client->get('posts', [
            'verify' => false, // отключает SSL проверку
            'query'  => [
                'per_page'   => $perPage,
                'page'       => $page,
                'categories' => 6,                               // ID  категории 
               // '_fields'    => 'id,title,slug,excerpt,acf', // Ограничение полей для оптимизации
                '_fields'    => 'id,title,slug,excerpt,content,acf,status',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        ($data);
        return $data;
    }

   public function createPostCurrent($title, $slug, $description, $category_menu_id){
    $newPost = AdvicePost::firstOrCreate(
        ['slug' => $slug],
         ['slug' => $slug,
        'title' => $title,  
        'content' => '',
        'description' => $description,
        'menu_id' => $category_menu_id,]);
            $this->post_id = $newPost->id;
            //dd('newPost', $newPost);
   return $newPost;
   }



    public function saveImages($images_array)
    {
     $records = [];
        foreach ($images_array as $item) {
            $records[] = [
                'advice_post_id'    => $this->post_id,  
                'filename'   => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ];
                   }
       // dd($records);
        AdvicePostImage::insert($records); 
       }

}


