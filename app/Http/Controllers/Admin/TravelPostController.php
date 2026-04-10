<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Posts\TravelPost;
use Illuminate\Http\Request;

/**
 * Работа с постами  travel в админке
 * обоих типов - для таблицы(пост типа final) и для одиночного поста(пост типа single)
 */
class TravelPostController extends Controller
{

/**
 * Метод для получения всех постов с пагинацией, поиском и сортировкой для админки
 * @param  Request $request  Объект запроса, содержащий параметры поиска, сортировки и пагинации
 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
 */

    public function index(Request $request)
{
    $query = TravelPost::query();

    // Поиск
    $search = $request->input('search');
    if (!empty($search)) {
        $query->where('title', 'like', "%{$search}%");
    }

    // Сортировка
    $sortBy = $request->input('sort_by', 'id');
    $sortDir = $request->input('sort_dir', 'desc');

    $allowedSorts = ['id', 'title'];

    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'id';
    }

    if (!in_array($sortDir, ['asc', 'desc'])) {
        $sortDir = 'desc';
    }

    $query->orderBy($sortBy, $sortDir);

    // Если нужен весь список без пагинации
    if ($request->boolean('all')) {
        return TravelResource::collection($query->get());
    }

    $perPage = (int) $request->input('per_page', 10);

    return TravelResource::collection($query->paginate($perPage));
}

  

/**
 * метод для получения поста для компонета редактирования
 * @param  int $id           ID поста для получения
 * @return TravelResource
 */
    public function postShow($id)
    {
        $travel = TravelPost::findOrFail($id);
        return new TravelResource($travel);
    }

    /**
     * метод для обновления поста
     * @param  Request $request  Объект запроса, содержащий обновленные данные
     * @param  int $id           ID поста для обновления
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $content         = $request->input('content');
        $travel          = TravelPost::findOrFail($id);
        $travel->content = $content;
        $travel->save();
        return response()->json(['message' => 'Travel post updated successfully']);

    }

/**
 * метод для переключения видимости поста
 * @param  int $id   ID поста для переключения видимости
 * @return \Illuminate\Http\JsonResponse
 */
    public function visual($id)
    {
        $travel            = TravelPost::findOrFail($id);
        $travel->is_visual = ! $travel->is_visual;
        $travel->save();
        return response()->json(['message' => 'Travel post visual status changed successfully', 'is_visual' => $travel->is_visual]);
    }

}
