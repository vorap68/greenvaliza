<?php
namespace App\Http\Controllers\Admin\ChangeTitle;

use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Services\ChangeTitleTravelService;
use Illuminate\Http\Request;

/**
 * Контроллер для изменения заголовков в категории travel в админке
 * непосредственное изменение заголовков происходит в сервисе ChangeTitleTravelService
 * контроллер отвечает за получение данных из запроса и передачу их в сервис, а также за возврат ответа клиенту
 */
class TitleTravelController
{

    protected $serviceTravelCat;

    /**
     * Конструктор для внедрения сервиса изменения заголовков в категории travel
     * @param ChangeTitleTravelService $serviceTravelCat
     */
    public function __construct(ChangeTitleTravelService $serviceTravelCat)
    {
        $this->serviceTravelCat = $serviceTravelCat;
    }

    /**
     * Метод для обновления заголовка поста в категории travel для компонента post single
     * @param  int $id ID поста для обновления
     * @param  Request $request Объект запроса, содержащий новый заголовок
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTravelPostSingle($id, Request $request)
    {
        $newTitle   = $request->input('title');
        $singlePost = TravelPost::with('travelMenu')->find($id);
        $result     = $this->serviceTravelCat->changeTitlePostSingle($singlePost, $newTitle);
        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }

    /**
     * Метод для обновления заголовка поста в категории travel для компонента post final
     * @param  int $id ID поста для обновления
     * @param  Request $request Объект запроса, содержащий новый заголовок
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTravelPostFinal($id, Request $request)
    {
        $newTitle  = $request->input('title');
        $finalPost = TravelPost::find($id);
        $result    = $this->serviceTravelCat->changeTitlePostFinal($finalPost, $newTitle);
        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }

    /**
     * Метод для обновления заголовка таблицы в категории travel для компонента table
     * @param  int $id ID таблицы для обновления
     * @param  Request $request Объект запроса, содержащий новый заголовок
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTravelTable($id, Request $request)
    {
        $newTitle  = $request->input('title');
        $tablePost = TravelTable::with('travelMenu')->find($id);
        $result    = $this->serviceTravelCat->changeTitleTable($tablePost, $newTitle);
        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }
}
