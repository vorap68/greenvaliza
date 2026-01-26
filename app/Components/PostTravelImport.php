<?php
namespace App\Components;

use App\Models\Images\TravelPostImage;
use App\Models\Posts\TravelPost;
use GuzzleHttp\Client; 

class PostTravelImport 
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

    public function getPosts($perPage = 2, $page = 2, $is_acf = 'post', $category_id = 2)
    {
        //dd($category_id, $is_acf);
        try {
            // Выполняем запрос
            $response = $this->client->request('GET', 'posts', [
                'verify'         => false, // отключает SSL проверку
                'timeout'        => 920,    // защита от зависания
                'http_errors'    => false, // не выбрасывает исключения при 4xx/5xx
                'decode_content' => true,  // обязательно — Guzzle дочитывает тело полностью
                'query'          => [
                    'per_page'   => $perPage,
                    'page'       => $page,
                    'categories' => $category_id, // ID категории
                    '_fields'    => 'id,title,slug,excerpt,content,acf,status',
                    //'_fields'    => 'title, slug, acf',
 
                ],
            ]); 

            // Принудительно вычитываем тело в строку
            $body = (string) $response->getBody();  

            // Преобразуем JSON безопасно
            $data = json_decode($body, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);

            // Проверим на ошибки декодирования
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Ошибка JSON: ' . json_last_error_msg());
            }

            if ($is_acf === 'table') {
                // Фильтруем посты с НЕпустым ACF полем 
                $tablePost = array_filter($data, fn($item) => ! empty($item['acf']));
                return $tablePost;
            }
            // Фильтруем посты с пустым ACF полем 
            $post = array_filter($data, fn($item) => empty($item['acf']));
            return $post;

        } catch (\Exception $e) {
            // Если что-то пошло не так — выведем понятное сообщение
            dd('Ошибка при загрузке постов:', $e->getMessage());
        }
    }

    public function savePosts($post_current)
    {
      try{
        $post = TravelPost::firstOrCreate(
            ['slug' => $post_current['slug']],
        $post_current);
       $this->post_id = $post->id;
            return $post;
      } catch (\Exception $e) {
        throw new \RuntimeException('Ошибка: не удалось сохранить пост: ' . $e->getMessage());
    }
}

    public function saveImages($images_array)
    {
        $records = [];
        foreach ($images_array as $item) {
            $records[] = [
                'travel_post_id' => $this->post_id,
                'filename'       => $item,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
            dump($this->post_id, $item  );
        }
       
        TravelPostImage::insert($records); 
    }

}
