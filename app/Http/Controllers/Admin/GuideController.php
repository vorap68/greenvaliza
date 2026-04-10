<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Posts\GuidePost;
use Illuminate\Http\Request;


/**
 * Работа с категорией guide в админке
 */
class GuideController extends Controller 

{
    /**
     * Метод для получения всех постов с пагинацией, поиском и сортировкой для админки
     * @param  Request $request  Объект запроса, содержащий параметры поиска, сортировки и пагинации
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request){
        
            $query = GuidePost::query();
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

      public function show($id){
    $guide = GuidePost::findOrFail($id);
       return new AllPostResource($guide);
    }
  

    /**
     * метод для обновления гайда
     * @param  Request $request  Объект запроса, содержащий обновленные данные
     * @param  int $id           ID гайда для обновления
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( Request $request,  $id ){
         $content = $request->input('content');
    $guide = GuidePost::findOrFail($id);
      $guide->content = $content;
      $guide->save();
      return response()->json(['message' => 'Guide post updated successfully']);
      
    }

    
/**
 * метод для переключения видимости поста
 * @param  int $id   ID поста для переключения видимости 
 * @return \Illuminate\Http\JsonResponse
 */
     public function visual($id){
      $guide = GuidePost::findOrFail($id);
      $guide->is_visual = !$guide->is_visual;
      $guide->save();
      return response()->json(['message' => 'Guide post visual status changed successfully', 'is_visual' => $guide->is_visual]);
    } 
}
