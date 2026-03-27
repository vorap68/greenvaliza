<?php
namespace App\Components;

use App\Services\ImageStoreToDB;
use Illuminate\Support\Facades\Storage;

class ImportImage
{
    public function imagesGetStore($html, $post_id, $category_name)
    {
        // регулярка ищет все пути /wp-content/uploads/ГОД/МЕСЯЦ/filename.jpg
        preg_match_all('#/wp-content/uploads/\d{4}/\d{2}/[^"\')\s>]+#i', $html, $matches);

        $allUrls          = array_unique($matches[0]); // убираем дубликаты
        $storagePathArray = [];

        foreach ($allUrls as $src) {
            // полный URL фото на WP сайте
            $fullUrl            = 'https://greenvaliza.co.ua' . $src;
            $imageName          = basename($src); // имя файла, например vien19.jpg
            $relativePathFolder = "images/{$category_name}/{$post_id}/original/{$imageName}";
            $storagePath        = storage_path("app/public/{$relativePathFolder}");
            $filePathArray[] = $storagePath;
            //здесь изменение записи полного пути изображения на имя файла
            $fileNameArray[] = $imageName;

                                                                                // пропускаем, если уже загружено
            if (file_exists($storagePath)) {                                    //!!!
                $html = str_replace($src, "/storage/{$relativePathFolder}", $html); //!!!
                continue;                                                           //!!!
            }

            // пробуем скачать
            $imageContent = @file_get_contents($fullUrl);
            if ($imageContent !== false) {
                Storage::disk('public')->put($relativePathFolder, $imageContent);
                // заменяем старый путь на новый
                $html = str_replace($src, "/storage/{$relativePathFolder}", $html);
            }
            dump($storagePath);
        }
        // вызываем сервис ресайзов пераем ВСЕ пути к фото
        $imageService = app(\App\Services\ImageService::class);
        $imageService->saveResizedImages($filePathArray);

        //создаем записи в БД для всех изображений, которые были импортированы для данного поста
        $store = new ImageStoreToDB();
        $store->imageStoreDb($fileNameArray, $post_id, $category_name);

        return [
            'html' => $html,
        ];
    }
}
