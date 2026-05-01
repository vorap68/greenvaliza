<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\ImageStoreToDB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Контроллер для обработки загрузки изображений и их сохранения
 */
class ImageCreatorController extends Controller
{
    protected ImageService $imageService;

    /**
     * Конструктор для внедрения зависимости ImageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Метод для создания изображения
     * @param string $category_name
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createImage($category_name, $id)
    {
        $images        = request()->images;
        $postTitle     = request()->post_title;
        $category_name = Str::camel($category_name);
        $path          = $category_name . '/' . $id . '/' . 'original/';
        $fileNameArray = []; // только имена для сохранения в БД
        $filePathArray = []; // полные пути для передачи на ресайз
        foreach ($images as $imageContent) {
            $imageName       = $imageContent->getClientOriginalName();
            $fileNameArray[] = $imageName; // только имя
                                           // Сохраняем оригинальное изображение на диск (1 файл)
            Storage::putFileAs('images/' . $path, $imageContent, $imageName);
            $folderPath = Storage::disk('public')->path("images/{$category_name}/{$id}/original/");
            //return response()->json(['folderPath'=>$folderPath]);
            $filename        = $folderPath . $imageName;
            $filePathArray[] = $filename;

        }
        $this->imageService->saveResizedImages($filePathArray);
        $store          = new ImageStoreToDB();
        $countNewImages = $store->imageStoreDb($fileNameArray, $id, $category_name);
        return response()->json([
            'saved_images' => $countNewImages,
            'post'         => $postTitle,
        ]);
    }

    /**
     * Метод для создания изображения без привязки к посту
      * @return \Illuminate\Http\JsonResponse   
     */
    public function createImageNoPost()
    {
        $images = request()->images;
        $dateImage     = now()->format('Y-m-d');
        $path          = $dateImage . '/' . 'original/';
        $fileNameArray = []; // только имена для БД
        $filePathArray = []; // полные пути для ресайза
        foreach ($images as $imageContent) {
            $imageName       = $imageContent->getClientOriginalName();
            $fileNameArray[] = $imageName; // только имя
             // Сохраняем оригинальное изображение на диск (1 файл)
            Storage::putFileAs('images/' . $path, $imageContent, $imageName);
            $folderPath = Storage::disk('public')->path("images/{$dateImage}/original/");
            //return response()->json(['folderPath'=>$folderPath]);
            $filename        = $folderPath . $imageName;
            $filePathArray[] = $filename;
        }
        $this->imageService->saveResizedImages($filePathArray);
         $store = new ImageStoreToDB();
         $countNewImages =  $store->imageStoreDb($fileNameArray, 0000, 'no-category');

       return response()->json([
            'saved_images' => $countNewImages,
            'post'         => 'Без поста',
        ]);
    }

}
