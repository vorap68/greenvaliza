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

     public function show($slug){ 
     $mybook = MybookPost::where('slug', $slug)->firstOrFail();
       return new MyBookResource($mybook);
    }
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $mybook = MybookPost::findOrFail($id);
      $mybook->content = $content;
      $mybook->save();
      return response()->json(['message' => 'Travel post updated successfully']);
      
    }

    public function getImages($post_id) {
      $postImages = MybookPostImage::where('mybook_post_id', $post_id)->get();
      return response()->json(['data' => $postImages]);
    }
   
   
}
