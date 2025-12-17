<?php
namespace App\Components;

use App\Models\Images\GuidePostImage;
use App\Models\Posts\GuidePost;
use GuzzleHttp\Client;

class PostGuideImport
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
            'verify'         => false, // отключает SSL проверку
            'timeout'        => 120,   // защита от зависания
            'http_errors'    => false, // не выбрасывает исключения при 4xx/5xx
            'decode_content' => true,  // обязательно — Guzzle дочитывает тело полностью
            'query'          => [
                'per_page'   => $perPage,
                'page'       => $page,
                'categories' => 86,
                '_fields'    => 'id,title,slug,excerpt,content,acf,status',
                //'_fields'    => 'id,title,slug,excerpt,acf', // Ограничение полей для оптимизации
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

        return $data;
    }

    public function savePosts($post_current)
    {
        try {
            $post = GuidePost::firstOrCreate(
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
                'guide_post_id'    => $this->post_id,
                'filename'   => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            }
            GuidePostImage::insert($records);

    }

}
