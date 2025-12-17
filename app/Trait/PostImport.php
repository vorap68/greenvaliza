<?php
namespace App\Trait;

use Illuminate\Support\Facades\Storage;

trait PostImport
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

    protected function getPosts( $perPage , $page )
    {
         
        $page =1;
        $allPosts = [];
        do{
        $response = $this->client->get('posts', [
            'verify' => false, // отключает SSL проверку
            'query'  => [
                'per_page'   => $perPage,
                'page'       => $page,
                'categories' => 85,
                '_fields'    => 'title, id,slug,link,excerpt,acf,categories,status',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $totalPages = $response->getHeader('X-WP-TotalPages')[0] ?? 1;
        $filteredAcf = array_filter($data,fn($item)=> empty($item['acf']));
        $filteredStatus = array_filter($filteredAcf,fn($item)=> $item['status'] === 'publish');
        $allPosts = array_merge($allPosts, $filteredStatus);
        $page++;
        } while ($page <= $totalPages);
        dd($allPosts);
        foreach($allPosts as $item){
            $newdata[]=[
                'id'=> $item['id'],
            'title' => $item['title']['rendered'],
            'categories' => $item['categories'][0],
            ];
      }
        dd($newdata);
       // return $data;
    }
}
//     protected function saveImages($imageUlr, $slug, $categoty_name)
//     {
//         $imageContent     = file_get_contents($imageUlr);
//         $filename         = basename($imageUlr);
//         $cleanUrl         = explode('?', $filename)[0];
//         $this->imageName  = pathinfo($filename, PATHINFO_FILENAME);
//         $this->imageExten = pathinfo($cleanUrl, PATHINFO_EXTENSION);
//         $relativePath     = "images/categoryMenu/{$categoty_name}/{$slug}/{$this->imageName}.{$this->imageExten}";
//         Storage::disk('public')->put($relativePath, $imageContent);
//     }

// }
