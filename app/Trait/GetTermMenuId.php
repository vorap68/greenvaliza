<?php
namespace App\Trait;

use Illuminate\Support\Facades\Storage;

trait GetTermMenuId
{
    protected $client;
   
    //public $category_name;

    protected function initClient()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://greenvaliza.co.ua/wp-json/wp/v2/',
            'timeout'  => 10.0,
        ]);
    }

    protected function getTermMenu( $perPage = 1, $page = 1)
    {
        $response = $this->client->get('categories', [
            'verify' => false, // отключает SSL проверку
            'query'  => [
                'per_page'   => $perPage,
                'page'       => $page,
               
               // '_fields'    => ' id,name,slug',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

  
}
