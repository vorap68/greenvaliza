<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Posts\TravelTable;
use Illuminate\Http\Request;

/**
 * Работа с таблицами travel в админке
 */
class TravelTableController extends Controller
{

/**
 * метод для получения всех таблиц
 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
 */
    public function index()
    {
        $traveltables = TravelTable::all();
        return TravelResource::collection($traveltables);
    }


    /**
     * метод для получения одной таблицы для компонента редактирования
      * @param  int $id           ID поста для получения
      * @return TravelResource  
     */
    public function tableShow($id)
    {
        $traveltable = TravelTable::where('id', $id)->firstOrFail();
        return response()->json(['data' => $traveltable]);
        return new TravelResource($traveltable);
    }

    /**
     * метод для обновления таблицы
      * @param  Request $request  Объект запроса, содержащий обновленные данные
      * @param  int $id           ID таблицы для обновления
      * @return \Illuminate\Http\JsonResponse   
     */
    public function update(Request $request, $id)
    {

        $content = $request->input('content');

        $traveltable          = TravelTable::findOrFail($id);
        $traveltable->content = $content;
        $traveltable->save();
        return response()->json(['message' => 'Travel traveltable updated successfully']);

    }

    /**
     * метод для переключения видимости таблицы
      * @param  int $id   ID таблицы для переключения видимости 
     */
    public function visual($id)
    {
        $traveltable            = TravelTable::findOrFail($id);
        $traveltable->is_visual = ! $traveltable->is_visual;
        $traveltable->save();
        return response()->json(['message' => 'Travel table visual status changed successfully', 'is_visual' => $traveltable->is_visual]);
    }

}
