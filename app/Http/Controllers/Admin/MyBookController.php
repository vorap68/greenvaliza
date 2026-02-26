<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\Posts\MybookPost;
use App\Http\Controllers\Controller;
use App\Http\Resources\MyBookResource;
use App\Models\Categories\MyBookMenu;
use App\Models\Images\MybookPostImage; 

class MyBookController extends Controller
{
    public function index()
    {
        $MyBook = MybookPost::all();
      return MyBookResource::collection($MyBook);
    }

     public function show($id){ 
     $mybook = MybookPost::findOrFail($id);
       return new MyBookResource($mybook);
    }
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $mybook = MybookPost::findOrFail($id);
      $mybook->content = $content;
      $mybook->save();
      return response()->json(['message' => 'Travel post updated successfully']);
      
    }

    public function getImages($id) {
      //dd($id);
      $postImages = MybookPostImage::where('mybook_post_id', $id)->get();
      return response()->json(['data' => $postImages]);
    }

       public function visual($id){
      $mybook = MybookPost::findOrFail($id);
      $mybook->is_visual = !$mybook->is_visual;
      $mybook->save();
      return response()->json(['message' => 'MyBook post visual status changed successfully', 'is_visual' => $mybook->is_visual]);
    } 
   
   
}
