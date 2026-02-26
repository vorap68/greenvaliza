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

    public function createImage($imageContent, $category = 'travel', $postMenu)
    {
        $path = "/images/categoryMenu/{$category}/{$postMenu->id}";
        // имя файла
        $filename = $imageContent->getClientOriginalName();
        // сохраняем оригинал
        Storage::disk('public')->putFileAs(
            $path,
            $imageContent,
            $filename
        );
        //️ получаем полный путь к файлу
        $fullPath = Storage::disk('public')->path(
            "{$path}/{$filename}"
        );
        //return $fullPath;
        //  передаём путь к ФАЙЛУ в сервис для создания ресайзов и сохранения их на диске
        return $this->imageService->saveResizedImages($fullPath, null);
    }

    public function createCard($title, $slug, $description, $image = null, $category = 'travel', $type = 'tble')
    {
        $imageName = $image?->getClientOriginalName() ?? '';
        $post      = [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'type'        => $type,
            'imageName'   => $imageName ?? '',

        ];

        //return response()->json(['post' => $post, 'category' => $category]);

        switch ($category) {
            case 'travel':
                return $post = TravelMenu::create($post);
                break;
            case 'guide':
                return $post = GuideMenu::create($post);
                break;
            case 'advice':
                return $post = AdviceMenu::create($post);
                break;
            case 'mybook':
                return $post = MyBookMenu::create($post);
                break;
        }

    }
}
