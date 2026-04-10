<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

/**
 * Контроллер для создания карточки меню и сохранения изображения для всех категорий, кроме travel-final
 * (для travel-final отдельный контроллер)
 */
class CardCreatorController extends Controller
{
    protected ImageService $imageService; 

    /**
     * Конструктор для внедрения сервиса обработки изображений
     * @param ImageService $imageService Сервис для обработки изображений, включая создание ресайзов и сохранение на диске
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

/**
 * метод для создания карточки меню в зависимости от категории (travel, guide, advice, mybook) 
 * @param string $title Заголовок карточки меню
 * @param string $slug Слаг для карточки меню, используемый в URL
 * @param string $description Описание карточки меню
 * @param Illuminate\Http\UploadedFile|null $image Загруженное изображение для карточки меню (необязательно)
 * @param string $category Категория, к которой относится карточка меню (travel, guide, advice, mybook)
 * @param string $type Тип карточки меню (например, 'tble' для таблицы, 'post' для поста)
 * @return object Возвращает созданную модель карточки меню в зависимости от категории
 */
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

    // switch ($category) {
    //         case 'travel':
    //             return $post = TravelMenu::make($post);
    //             break;
    //         case 'guide':
    //             return $post = GuideMenu::make($post);
    //             break;
    //         case 'advice':
    //             return $post = AdviceMenu::make($post);
    //             break;
    //         case 'mybook':
    //             return $post = MyBookMenu::make($post);
    //             break;
    //     }
    // }

    /**
     * метод для сохранения изображения на диске и создания ресайзов для карточки меню
     * @param   $imageContent  Содержимое загруженного изображения для сохранения
     * @param  string $category  Категория, к которой относится изображение
     * @param  object $postMenu  Модель карточки меню, для которой сохраняется изображение
     * @return array{
     *     success: bool,
     *     message: string,
     *     File_Location: string,
     * }
     */
    public function createImage($imageContent, $category = 'travel', $postMenu)
    {
        try{
             // путь для сохранения изображения на диске, включая категорию и ID поста
            $path = "images/categoryMenu/{$category}/{$postMenu->id}/original";
            // имя файла
            $filename = $imageContent->getClientOriginalName();
            // return response()->json(['message' => 'Путь для сохранения изображения сформирован (controller)',
            // 'path' => $path,
            // 'filename' => $filename,]);
            // сохраняем оригинал и проверяем успешность сохранения
            Storage::disk('public')->putFileAs(
                $path,
                $imageContent,
                $filename
            );
            //️ получаем полный путь к файлу
            $fullPath = Storage::disk('public')->path(
                "{$path}/{$filename}"
            );

            if (! file_exists($fullPath)) {
                return ['success' => false, 'message' => 'Error saving image (controller)'];
            }

           // return  $fullPath;    
             //  передаём путь к ФАЙЛУ в сервис для создания ресайзов и сохранения их на диске
             $res = $this->imageService->saveResizedImages($fullPath, null);
             if (! $res) {
                 return ['success' => false, 'message' => 'Error creating resized images (controller)'];
             }
                
             return [
                'success' => true,
                 'message' => 'Image and resized versions saved successfully',
                  'File_Location'=> $fullPath,
             ];
         } catch (\Exception $e) {
             return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
         }
    }
    

}
