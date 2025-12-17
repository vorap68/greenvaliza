<?php
namespace App\Components;

use GuzzleHttp\Client;
// use App\Models\Images\ImagePost;
use App\Models\PostImage;
use App\Components\ImportImage;
use App\Models\Posts\TravelPost;

class ImportSinglePost
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
    public function getPost($PostId)
    {
        //dd($PostId,$CategoryId);
        $response = $this->client->get('posts/' . $PostId, [
            'verify' => false, // отключает SSL проверку
            'query'  => [
               // '_fields' => 'id,title,slug,excerpt', // Ограничение полей для оптимизации
            ],
        ]); 

       $data         = json_decode($response->getBody()->getContents(), true);
        dd($data);
        $html = $data['content']['rendered'];
        // Извлечение текста из HTML
        $text = strip_tags($html);
        // Удаление лишних пробелов и переносов строк
        $cleanedText = preg_replace('/\s+/', ' ', $html);
        // dd($cleanedText);
        $description = strip_tags($data['excerpt']['rendered']);
        $description = preg_replace('/\s+/', ' ', $description);
        // dd($description);
        $slug = $data['slug'];

       // $images       = new ImportImage();
      //  $images_array = $images->imagesGet($html, $slug);
        $post_current = [
            'content'     => $cleanedText,
            'travel_id'   => $CategoryId,
            'title'       => $data['title']['rendered'],
            'slug'        => $slug,
            'description' => $description,
        ];
        //$post_id = TravelPost::firstOrCreate($post_current)->id;
        $records = [];

        foreach ($images_array as $item) {
            $records[] = [
                'post_id'    => $post_id,
                'filename'   => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

       // ImagePost::insert($records, 'travel_posts');
      // PostImage::create($records);
}
    
}


