<?php
namespace App\Components;

use Illuminate\Support\Facades\Storage;

class ImportImage
{
    public function imagesGetStore($html, $slug, $category_name)
    {

        // регулярка ищет все пути /wp-content/uploads/ГОД/МЕСЯЦ/filename.jpg
        preg_match_all('#/wp-content/uploads/\d{4}/\d{2}/[^"\')\s>]+#i', $html, $matches);

        $allUrls      = array_unique($matches[0]); // убираем дубликаты
        $images_array = [];

        foreach ($allUrls as $src) {
            // полный URL фото на WP сайте
            $fullUrl = 'https://greenvaliza.co.ua' . $src;

            $imageName = basename($src); // имя файла, например vien19.jpg

            $relativePath = "images/{$category_name}/{$slug}/{$imageName}";
            //dd( $relativePath);

            $storagePath    = storage_path("app/public/{$relativePath}");
            $images_array[] = $relativePath;

            // пропускаем, если уже загружено
            if (file_exists($storagePath)) {
                $html = str_replace($src, "/storage/{$relativePath}", $html);
                continue;
            }

            // пробуем скачать
            $imageContent = @file_get_contents($fullUrl);
            if ($imageContent !== false) {
                Storage::disk('public')->put($relativePath, $imageContent);
                // заменяем старый путь на новый
                $html = str_replace($src, "/storage/{$relativePath}", $html);
            }
        }

        return [
            'html'         => $html,
            'images_array' => $images_array,
        ];
    }
}
