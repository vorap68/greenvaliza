<?php
namespace App\Components;
 
use App\Models\Post;
use GuzzleHttp\Client;
use App\Components\ImportImage;
use App\Models\Guide;
use App\Models\MyBook;
use Illuminate\Support\Facades\Storage;

class ImportMenuGuides
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
    public function getGuideMenu($perPage = 100, $page = 1)
    {
        
        $response = $this->client->get('posts', [
            'verify' => false, // отключает SSL проверку
            'query'  => [
                'per_page'   => $perPage,
                'page'       => $page,
                'categories' => 86, 
                // здесь меняем id категории и получаем посты этой категории
                // 86 - путеводители
             

                 '_fields'    => 'title, id,slug,link,excerpt,jetpack_featured_media_url' 
            ],
        ]);

     
        $data = json_decode($response->getBody()->getContents(), true);
      
        foreach ($data as $item) {
             dd($item);
            $description = strip_tags($item['excerpt']['rendered']);
            $description = preg_replace('/\s+/', ' ', $description);
            $slug = $item['slug'];

            //здесь я уже получаю url картинки
            $imageUlr = $item['jetpack_featured_media_url'];
                
                 $imageContent = file_get_contents($imageUlr);
                 
                $filename = basename($imageUlr);
                $imageName = pathinfo($filename, PATHINFO_FILENAME);
                $imageExten = pathinfo($filename, PATHINFO_EXTENSION);
             
                // Save the image content to a local file
                // Здесь меняем путь в зависимости от категории
                 $relativePath = "images/categoryMenu/putevoditeli/{$slug}/{$imageName}.{$imageExten}";// для путеводителей
                Storage::disk('public')->put($relativePath, $imageContent);
      
            $item_current  = [
               'title'       => $item['title']['rendered'],
                'slug'        => $slug,
                'description' => $description,
                'imageName' => $imageName,
                'imageExten' => $imageExten
            ];

             // Здесь меняем Класс в зависимости от категории
             Guide::create($item_current); // для путеводителей
          }

    }

 
}


