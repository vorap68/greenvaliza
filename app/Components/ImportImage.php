<?php
namespace App\Components;

use DOMDocument; 
use GuzzleHttp\Client;  
use Illuminate\Support\Facades\Storage;

class ImportImage
{
   public function imagesGet($html, $slug) {
     
            // Извлечение всех изображений из HTML
              $dom  = new DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
            $xpath  = new \DOMXPath($dom);
            $nodes  = $xpath->query("//img");
            $images = [];//
            foreach ($nodes as $node) {
             
                $src= $node->getAttribute("src");
                dd($src);
                 $images[]= $src;
                 //dd($src);
               
                // Get the content of the image from the URL
                $imageContent = file_get_contents('https://greenvaliza.co.ua'.$src);
                $imageName = basename($src);
                // Save the image content to a local file
                 $relativePath = "images/posts/{$slug}/{$imageName}";
                Storage::disk('public')->put($relativePath, $imageContent);
    
   }
}
}