<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Posts\GuidePost;
use Illuminate\Http\Request;


class GuideController extends Controller 

{
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

//метод для получения поста для компонета редактирования
      public function show($id){
    $guide = GuidePost::findOrFail($id);
       return new AllPostResource($guide);
    }
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $guide = GuidePost::findOrFail($id);
      $guide->content = $content;
      $guide->save();
      return response()->json(['message' => 'Guide post updated successfully']);
      
    }

    

     public function visual($id){
      $guide = GuidePost::findOrFail($id);
      $guide->is_visual = !$guide->is_visual;
      $guide->save();
      return response()->json(['message' => 'Guide post visual status changed successfully', 'is_visual' => $guide->is_visual]);
    } 
}
