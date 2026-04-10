<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Posts\AdvicePost;
use Illuminate\Http\Request;

/**
 * Работа с советами и полезностями в админке
 */
class AdviceController extends Controller
{
    /**
     * Метод для получения всех постов с пагинацией, поиском и сортировкой для админки
     * @param  Request $request  Объект запроса, содержащий параметры поиска, сортировки и пагинации
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    { 
        $query = AdvicePost::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query  = $query->where('title', 'like', "%{$search}%");
        }
        $sortBy  = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);
        if ($request->boolean('all')) {
          
            return AllPostResource::collection($query->get());
        }
        return AllPostResource::collection($query->paginate(10));
    }

    /**
     * Метод для обновления совета
     * @param  Request $request  Объект запроса, содержащий обновленные данные
     * @param  int $id           ID совета для обновления
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $content         = $request->input('content');
        $advice          = AdvicePost::findOrFail($id);
        $advice->content = $content;
        $advice->save();
        return response()->json(['message' => 'advice post updated successfully']);
    }

    /**
     * метод для получения поста для компонета редактирования
     * @param  int $id           ID поста для получения
     * @return AllPostResource
     */
    public function show($id)
    {
        $guide = AdvicePost::findOrFail($id);
        return new AllPostResource($guide);
    }

     /**
      *  метод для переключения видимости поста
      * @param  int $id   ID поста для переключения видимости 
      */   
    public function visual($id)
    {
        $advice            = AdvicePost::findOrFail($id);
        $advice->is_visual = ! $advice->is_visual;
        $advice->save();
        return response()->json(['message' => 'Advice post visual status changed successfully', 'is_visual' => $advice->is_visual]);
    }
}
