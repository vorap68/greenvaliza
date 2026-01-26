<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Services\ImageService;

class ImageCreatorController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function createImage() 
    {
        // $response = request()->all();
        // return response()->json(['picture' => $response]);
        dd(request()->all());

        //$path = 'categoryMenu/' . $category . '/' . $slug;

        // Сохраняем оригинальное изображение на диск (1 файл)
        // Storage::putFileAs('images/' . $path, $imageContent, $imageContent->getClientOriginalName()); 
        // $folderPath = Storage::disk('public')->path("images/categoryMenu/{$category}/{$slug}");

        // $source = $folderPath . '/' . $imageContent->getClientOriginalName();
        // $this->imageService->saveResizedImages($source, $path, null);
    }

 
}
