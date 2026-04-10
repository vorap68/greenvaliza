<?php
namespace App\Http\Controllers\Admin\ChangeTitle;

use App\Models\Posts\AdvicePost;
use App\Services\ChangeTitleAllCatService;
use Illuminate\Http\Request;

/**
 * Контроллер для изменения заголовков в категориях (guide, advice, mybook) в админке
 *  непосредственное изменение заголовков происходит в сервисе ChangeTitleAllCatService
 * контроллер отвечает за получение данных из запроса и передачу их в сервис, а также за возврат ответа клиенту
 */
class TitleAllCategoryController
{
    protected $serviceAllCat;

    /**
     *  Конструктор для внедрения сервиса изменения заголовков
     * @param  ChangeTitleAllCatService $serviceAllCat  Сервис для изменения заголовков
     */
    public function __construct(ChangeTitleAllCatService $serviceAllCat)
    {
        $this->serviceAllCat = $serviceAllCat;
    }

    /**
     * Метод для обновления заголовка поста в зависимости от категории (кроме travel)
     * @param  string $category_name  Название категории (guide, advice, mybook)
     * @param  int $id                ID поста для обновления
     * @param  Request $request        Объект запроса, содержащий новый заголовок
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAllCat($category_name, $id, Request $request)
    {
        $newTitle = $request->input('title');
        // Логика изменения заголовка в зависимости от категории
        switch ($category_name) {
            case 'guide':
                $modelClass = \App\Models\Posts\GuidePost::class;
                $menuClass  = 'guideMenu';
                break;
            case 'advice':
                $modelClass = AdvicePost::class;
                $menuClass  = 'adviceMenu';

                break;
            case 'mybook':
                $modelClass = \App\Models\Posts\MybookPost::class;
                $menuClass  = 'mybookMenu';
                break;
            default:
                return response()->json(['message' => 'Invalid category name'], 400);
        }

        $post = $modelClass::with($menuClass)->find($id);

        if (! $post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Вызов сервиса для изменения путей
        $result = $this->serviceAllCat->changeTitleCatAll($post, $menuClass, $newTitle);
        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);
    }

}
