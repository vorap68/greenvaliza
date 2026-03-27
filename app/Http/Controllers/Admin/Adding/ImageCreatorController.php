<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageStoreToDB;

class ImageCreatorController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function createImage($category_name, $id)
    {
        $images = request()->images;
        // return response()->json([ 'category' => $category_name, 'id' => $id]);
        $category_name = str_replace('-', '/', $category_name);
        $path = $category_name . '/' . $id . '/' . 'original/';
         $fileNameArray = [];    // только имена для БД
        $fullPathArray = [];    // полные пути для ресайза
        foreach ($images as $imageContent) {
            $imageName = $imageContent->getClientOriginalName();
              $fileNameArray[] = $imageName;   // только имя
            // Сохраняем оригинальное изображение на диск (1 файл)
            Storage::putFileAs('images/' . $path, $imageContent, $imageName);
            $folderPath = Storage::disk('public')->path("images/{$category_name}/{$id}/original/");
            //return response()->json(['folderPath'=>$folderPath]);
            $filename        = $folderPath . $imageName;
            $filePathArray[] = $filename;
            
        }
         //return response()->json(['message' =>  $fileNameArray]);
        $result = $this->imageService->saveResizedImages($filePathArray);
         $store = new ImageStoreToDB();
          $store->imageStoreDb($fileNameArray,$id,$category_name);

        return response()->json(['message' =>  $result]);
    }
    public function createImageNoPost()
    {
        $images = request()->images;
        // return response()->json([ 'category' => $category_name, 'id' => $id]);
        $dateImage = now()->format('Y-m-d');
        $path = $dateImage . '/' . 'original/';
         $fileNameArray = [];    // только имена для БД
        $fullPathArray = [];    // полные пути для ресайза
        foreach ($images as $imageContent) {
            $imageName = $imageContent->getClientOriginalName();
              $fileNameArray[] = $imageName;   // только имя
            // Сохраняем оригинальное изображение на диск (1 файл)
            Storage::putFileAs('images/' . $path, $imageContent, $imageName);
            $folderPath = Storage::disk('public')->path("images/{$dateImage}/original/");
            //return response()->json(['folderPath'=>$folderPath]);
            $filename        = $folderPath . $imageName;
            $filePathArray[] = $filename;
            
        }
         //return response()->json(['message' =>  $fileNameArray]);
        $result = $this->imageService->saveResizedImages($filePathArray);
        //  $store = new ImageStoreToDB();
        //   $store->imageStoreDb($fileNameArray,$id,$category_name);

        return response()->json(['message' =>  $result]);
    }

}
