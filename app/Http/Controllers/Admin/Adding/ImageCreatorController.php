<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

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
        // return response()->json(['picture' => $response, 'category' => $category_name, 'id' => $id]);
        // dd(request()->all());
        $category_name = str_replace('-', '/', $category_name);

        $path =  $category_name . '/' . $id;

        foreach ($images as $imageContent) {
        // Сохраняем оригинальное изображение на диск (1 файл)
        Storage::putFileAs('images/' . $path, $imageContent, $imageContent->getClientOriginalName()); 
        
        $folderPath = Storage::disk('public')->path("images/{$category_name}/{$id}");
        }

            // $this->imageService->createImage($category_name, $id, $folderPath);
            // return response()->json(['message' => 'Изображения успешно сохранены.']);
    }

 
}
