<?php
namespace App\Components;

use App\Models\Post;
use GuzzleHttp\Client;
use App\Components\ImportImage;

class ImportPost
{
    public $client;

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
                'categories' => 2, // ID  категории
                  '_fields'    => 'id,title,slug,excerpt,content', // Ограничение полей для оптимизации
            ],
        ]);
        $putevoditeli = [];
        $data         = json_decode($response->getBody()->getContents(), true);
      
        //dd($data);
        foreach ($data as $item) {
             //dd($item);
            $html = $item['content']['rendered'];
            // Извлечение текста из HTML
            $text = strip_tags($html);
            // Удаление лишних пробелов и переносов строк
            $cleanedText = preg_replace('/\s+/', ' ', $html);
            // dd($cleanedText);
            $description = strip_tags($item['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
            // dd($description);
            $slug = $item['slug'];
          
           $images = new ImportImage();
           $images->imagesGet($html, $slug);
            $post_current  = [
                'content'     => $cleanedText,
                'travel_id'    => 2,
                'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
            ];
             Post::create($post_current);
             //$putevoditeli[] = $post_current; 
          }

    }

    // foreach ($putevoditeli as $post) {
    //     // dd($post);
    //     Post::create([
    //         'category_id' => 2,
    //         'title'       => $post['title'],
    //         'slug'        => $post['slug'],
    //         'description' => $post['description'],
    //         'content'     => $post['content'],
    //     ]);
    // }
    //print_r($data[0]);
    // print_r($putevoditeli);

    // dd(array_slice($data, 0, 2)); // первые 2 поста

    //return $response;
}


