<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class CardCreatorController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function createImage($imageContent, $slug , $category = 'travel')
    {

        $path = 'categoryMenu/' . $category . '/' . $slug;

        // Сохраняем оригинальное изображение на диск (1 файл)
        Storage::putFileAs('images/' . $path, $imageContent, $imageContent->getClientOriginalName()); 
        $folderPath = Storage::disk('public')->path("images/categoryMenu/{$category}/{$slug}");

        $source = $folderPath . '/' . $imageContent->getClientOriginalName();
        $this->imageService->saveResizedImages($source, $path, null);
    }

    public function createCard($title, $slug, $description,  $image = null ,$category='travel', $type='posts')
    {
        $imageName  = $image?->getClientOriginalName() ?? '';
        $imageExten = $image?->getClientOriginalExtension() ?? '';
       
        
        $post = [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'type'        => $type,
            'imageName'   => pathinfo($imageName, PATHINFO_FILENAME) ?? '',
            'imageExten'  => $imageExten,
        ];
        // return response()->json(['post' => $post]);
       
        switch ($category) {
            case 'travel':
                TravelMenu::create($post);
                break;
            case 'guide':
                GuideMenu::create($post);
                break;
            case 'advice':
                AdviceMenu::create($post);
                break;
            case 'mybook':
                MyBookMenu::create($post);
                break;
        }
       
    }
}
