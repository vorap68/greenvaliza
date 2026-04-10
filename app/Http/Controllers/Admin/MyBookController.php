<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Posts\MybookPost;
use Illuminate\Http\Request;

/**
 * Работа с категорией mybook в админке
 */
class MyBookController extends Controller
{

/**
 * Метод для получения всех постов с пагинацией, поиском и сортировкой для админки
 * @param  Request $request  Объект запроса, содержащий параметры поиска, сортировки и пагинации
 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
 */
    public function index(Request $request)
    {
        $query = MybookPost::query();

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
     * метод для получения поста для компонета редактирования
     * @param  int $id           ID поста для получения
     * @return AllPostResource
     */
    public function show($id)
    {
        $guide = MybookPost::findOrFail($id);
        return new AllPostResource($guide);
    }

    /**
     * метод для обновления поста
     * @param  Request $request  Объект запроса, содержащий обновленные данные
     * @param  int $id           ID поста для обновления
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $content = $request->input('content');

        $mybook          = MybookPost::findOrFail($id);
        $mybook->content = $content;
        $mybook->save();
        return response()->json(['message' => 'Travel post updated successfully']);

    }

    /**
     * метод для переключения видимости поста
     * @param  int $id   ID поста для переключения видимости
     * @return \Illuminate\Http\JsonResponse
     */
    public function visual($id)
    {
        $mybook            = MybookPost::findOrFail($id);
        $mybook->is_visual = ! $mybook->is_visual;
        $mybook->save();
        return response()->json(['message' => 'MyBook post visual status changed successfully', 'is_visual' => $mybook->is_visual]);
    }

}
