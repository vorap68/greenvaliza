<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Http\Resources\TravelResource;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 *  Работа с card-menu в админке всех 4-х категорий: guide, travel, advice, mybook
 */
class PostCardController extends Controller
{
    protected ImageService $imageService;

    /**
     * Конструктор для внедрения зависимости ImageService
     * @param ImageService $imageService Сервис для работы с изображениями
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Метод для получения данных выбранной категории для компонента card-menu
     * @param  string $category_name Название категории для получения данных
     */
    public function index($category_name)
    {
        $postcards = match ($category_name) {
            'travel' => TravelResource::collection(TravelMenu::all()),
            'guide'  => AllPostResource::collection(GuideMenu::all()),
            'advice' => AllPostResource::collection(AdviceMenu::all()),
            'mybook' => AllPostResource::collection(MyBookMenu::all()),
        };
        return response()->json($postcards);
    }

   

/**
 * метод для получения данных одного поста card-menu 
 * @param  string $category_name Название категории для получения данных
 * @param  int $id   ID поста для получения данных
 * @return \Illuminate\Http\JsonResponse
 */
    public function show($category_name, $id)
    {
        response()->json(['category_name' => $category_name, 'id' => $id]);
        $postcard = match ($category_name) {
            'travel' => new TravelResource(TravelMenu::where('id', $id)->firstOrFail()),
            'guide'  => new AllPostResource(GuideMenu::where('id', $id)->firstOrFail()),
            'advice' => new AllPostResource(AdviceMenu::where('id', $id)->firstOrFail()),
            'mybook' => new AllPostResource(MyBookMenu::where('id', $id)->firstOrFail()),
        };
        return response()->json($postcard);
    }


    /**
     * метод для обновления данных одного поста card-menu
     * @param  Request $request  Объект запроса, содержащий обновленные данные
     * @param  string $category_name Название категории для обновления данных
     * @param  int $id   ID поста для обновления данных
     * @return \Illuminate\Http\JsonResponse    
     */
    public function update(Request $request, $category_name, $id)
    {
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:14096',
        ]);

        $postcard = $this->getPostCard($category_name, $id);

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $path       = 'images/categoryMenu/' . $category_name . '/' . $postcard->id . '/original';
            $fileName   = $image->getClientOriginalName();
            $fullPath[] = Storage::disk('public')->path(
                "{$path}/{$fileName}"
            );
            Storage::putFileAs($path, $image, $fileName);
            $successResize       = $this->imageService->saveResizedImages($fullPath, null);
            $postcard->imageName = $fileName;
        }
        $postcard->title = $validated['title'];
        $postcard->description = $validated['description'];
        $postcard->save();
        return response()->json($postcard);
    }

    /**
     * метод для переключения видимости поста card-menu
      * @param  string $category_name Название категории 
      * @param  int $id   ID поста для переключения видимости
      * @return \Illuminate\Http\JsonResponse
     */
 public function visual($category_name, $id)
    {
       $postcard = $this->getPostCard($category_name, $id);
        $postcard->is_visual = ! $postcard->is_visual;
        $postcard->save();
        return response()->json(['is_visual' => $postcard->is_visual]);
    }

    /**
     * приватный метод для получения модели поста card-menu по категории и ID
      * @param  string $category_name 
      * @param  int $id   ID поста для получения модели
      * @return  экземпляр одной из моделей $postcard
      * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private function getPostCard($category_name,$id) 
    {
      $postcard = match ($category_name) {
            'travel' => TravelMenu::where('id', $id)->firstOrFail(),
            'guide'  => GuideMenu::where('id', $id)->firstOrFail(),
            'advice' => AdviceMenu::where('id', $id)->firstOrFail(),
            'mybook' => MyBookMenu::where('id', $id)->firstOrFail(),
        };
        return $postcard;
    }
}
