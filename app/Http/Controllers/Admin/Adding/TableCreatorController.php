<?php
namespace App\Http\Controllers\Admin\Adding;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SlugService;
use App\Models\Posts\TravelTable;
use App\Http\Controllers\Controller;

/**
 *  Контроллер для создания поста-таблицы в категории travel, включая создание карточки меню и сохранение изображения
 *  В процессе создания поста-таблицы выполняются следующие шаги:
 *  1. Валидация входящих данных (заголовок, описание, изображение)
 *  2. Генерация слага на основе заголовка
 *  3. Создание карточки меню для новой таблицы с помощью CardCreatorController
 *  4. Сохранение изображения на диске и создание ресайзов с помощью метода createImage из CardCreatorController
 *  5. Создание записи поста-таблицы в базе данных с привязкой к карточке меню
 *  6. Возвращение JSON-ответа с ID созданного поста для дальнейшего редиректа на страницу редактирования поста-таблицы
 */
class TableCreatorController extends Controller
{

protected SlugService $slugService;

/**
 * Конструктор для инициализации сервиса генерации слагов
 */
    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }
    

    /** 
     * метод для создания поста-таблицы в категории travel, включая создание карточки меню и сохранение изображения
     * @param Request $request HTTP-запрос, содержащий данные для создания поста-таблицы (заголовок, описание, изображение)
     * @param CardCreatorController $cardCreate Контроллер для создания карточки меню и сохранения изображения
     * @return \Illuminate\Http\JsonResponse JSON-ответ с ID созданного поста-таблицы 
     */
    public function createTable(Request $request, CardCreatorController $cardCreate)
    {
       $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:14096',
        ]);

       $slug = $this->slugService->make($validated['title']); 

  // Создаем запись в главном меню категории - пост-заставку
        // метод из CardCreatorController
        $postCard = $cardCreate->createCard(
               title: $validated['title'],
                slug: $slug,
                description: $validated['description'],
                image: $validated['image'],
                type: 'tble',
        );
    if (! $postCard) {  
        return response()->json(['message' => 'Error creating menu card'], 500);
    }
              // Сохряняем изображение на диске и создаем ресайзы
            // метод createImage из CardCreatorController
            if ($request->hasFile('image')) {
                $imageContent = $request->file('image');
               $imageResult = $cardCreate->createImage($imageContent, $category = 'travel', $postCard);
               if (! $imageResult['success']) {
                   return response()->json(['message' => 'Фото или ресайзы не сохранились (controller)'], 500);
               }
          
          } else {
                return response()->json(['message' => 'фото не выбрано']);};

                // Создаем сырой контент для поста-таблицы из шаблона Blade 
        $content = view('travel_table')->render();

        // Создание поста в таблице для категории travelTable
         $value = [
                'title'           => $validated['title'],
                'slug'            => $slug,
                'description'     => $validated['description'],
                'content'         => $content,
                'menu_id'         => $postCard->id,
            ];
               $post = TravelTable::create($value);
            if (! $post) {
                return response()->json(['message' => 'Error creating travel post'], 500);
            }
             return response()->json(['post_id' => $post->id,
            'File_Location' => $imageResult['File_Location']]);
    }
    
}
