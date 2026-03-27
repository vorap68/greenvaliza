<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Categories\MyBookMenu;
use App\Models\Posts\MybookPost;
use Illuminate\Http\Request;

class MyBookController extends Controller
{
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

    //метод для получения поста для компонета редактирования
      public function show($id){
    $guide = MybookPost::findOrFail($id);
       return new AllPostResource($guide);
    }
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $mybook = MybookPost::findOrFail($id);
      $mybook->content = $content;
      $mybook->save();
      return response()->json(['message' => 'Travel post updated successfully']);
      
    }

   

       public function visual($id){
      $mybook = MybookPost::findOrFail($id);
      $mybook->is_visual = !$mybook->is_visual;
      $mybook->save();
      return response()->json(['message' => 'MyBook post visual status changed successfully', 'is_visual' => $mybook->is_visual]);
    } 
   
   
}
