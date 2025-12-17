<?php
namespace App\Components;

use App\Models\Images\MybookPostImage;
use App\Models\Posts\MybookPost;
use GuzzleHttp\Client;

class PostMyBookImport 
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
                'categories' => 3,                               // ID  категории 2-Наши путешествия 
                '_fields'    => 'id,title,slug,excerpt,content,acf', // Ограничение полей для оптимизации
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        return $data;
    }

   

    public function savePosts($post_current)
    {
        try {
            $post = MybookPost::firstOrCreate(
                ['slug' => $post_current['slug']],
                $post_current);
            $this->post_id = $post->id;
        } catch (\Exception $e) {
            throw new \RuntimeException('Ошибка: не удалось сохранить пост: ' . $e->getMessage());
        }
    }

    public function saveImages($images_array)
    {
        $records = [];
        foreach ($images_array as $item) {
            $records[] = [
                'mybook_post_id'    => $this->post_id,
                'filename'   => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ];
           
        }
           MybookPostImage::insert($records);

       
      
    }

}


