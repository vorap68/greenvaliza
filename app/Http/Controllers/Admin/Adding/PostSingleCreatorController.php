<?php
namespace App\Http\Controllers\Admin\Adding;

use Illuminate\Http\Request;
use App\Services\SlugService;
use App\Models\Posts\GuidePost;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;
use App\Http\Controllers\Controller;


/**
 * Контроллер для создания поста во всех  категориях кроме travel-final 
 * (для travel-final отдельный контроллер) 
 */
class PostSingleCreatorController extends Controller  
{
 protected SlugService $slugService;

 /**
  * Конструктор для внедрения сервиса генерации slugов
  * @param SlugService $slugService 
  */
    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }


    /**
     * метод для создания поста в категориях travel, guide, advice, mybook для компонента post single
     * @param  Request $request  Объект запроса, содержащий данные для создания поста
     *   заголовок, описание, категория, родительский заголовок (для таблицы) и изображение (для карточки меню)
     * @param  CardCreatorController $cardCreate  Контроллер для создания карточки меню и сохранения изображения
     * @return \Illuminate\Http\JsonResponse    
     */
    public function createPost(Request $request, CardCreatorController $cardCreate) 
    {
        $validated = $request->validate([
            'title'        => 'required|string',
            'description'  => 'nullable|string',
            'category'     => 'required|string',
            'parent_title' => 'nullable|string',
            'image'        => 'nullable|image|max:14096', 
        ]);
          
          $slug = $this->slugService->make($validated['title']); 
            // Создаем запись в главном меню категории - пост-заставку
             // метод createCard из CardCreatorController
            $postCard = $cardCreate->createCard(
                title: $validated['title'],
                slug: $slug,
                description: $validated['description'],
                image: $validated['image'],
                category: $validated['category'],
                type: 'post'
            );

              // Сохряняем изображение на диске и создаем ресайзы
            // метод createImage из CardCreatorController
            if ($request->hasFile('image')) {
               $imageContent = $request->file('image');
               $imageResult = $cardCreate->createImage($imageContent, $validated['category'], $postCard);
               if (! $imageResult['success']) {
                   return response()->json(['message' => 'Фото или ресайзы не сохранились (controller)'], 500);
               }
            //    return response()->json(['message' => 'Фото сохранено успешно (controller)',
            //   'image_result' => $imageResult]);
            } else {
                return response()->json(['message' => 'фото не выбрано']);};
        
     // Создание поста в таблице. 
            $model = match ($validated['category']) {
                'travel'  => TravelPost::class,
                'guide'  => GuidePost::class,
                'advice' => AdvicePost::class,
                'mybook' => MybookPost::class,
            };
           
            $post = $model::create([
                'title'       => $validated['title'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'content'     => '',
                'menu_id'     => $postMenu->id ?? null,
            ]);
            if (! $post) {
                return response()->json(['message' => 'Error creating post (controller)'], 500);
            }
            return response()->json(['post_id' => $post->id,
            'File_Location' => $imageResult['File_Location']]);
        
    }

}
