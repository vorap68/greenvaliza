<?php
namespace App\Trait;

use Illuminate\Support\Facades\Storage;

trait CategoryImport
{
    protected $client;
    public $imageExten;
    public $imageName;
    //public $category_name;

    protected function initClient()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://greenvaliza.co.ua/wp-json/wp/v2/',
            'timeout'  => 10.0,
        ]);
    }

    protected function getPosts($perPage=10, $page = 1, $category_id )
    {
        $response = $this->client->get('posts', [
            'verify' => false, // отключает SSL проверку
            'query'  => [
                'per_page'   => $perPage,
                'page'       => $page,
                'categories' => $category_id,
                '_fields'    => 'title, id,slug,link,excerpt,jetpack_featured_media_url,acf,categories,status',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    protected function saveImages($imageUlr, $cleanFileName,$post_id, $category_name)
    {
        $imageContent     = file_get_contents($imageUlr);
      $relativePath     = "images/categoryMenu/{$category_name}/{$post_id}/{$cleanFileName}";
        Storage::disk('public')->put($relativePath, $imageContent);
    }

}
