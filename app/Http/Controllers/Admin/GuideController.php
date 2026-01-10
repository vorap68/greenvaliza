<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\Posts\GuidePost;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;
use App\Models\Images\GuidePostImage;


class GuideController extends Controller 

{
    public function index(){
        
       $guide =  GuidePost::all();
       //dd($guide);
        return GuideResource::collection($guide);
    }
      public function show($slug){
      //return response()->json($slug);
        $guide = GuidePost::where('slug', $slug)->firstOrFail();
       return new GuideResource($guide);
    }
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $guide = GuidePost::findOrFail($id);
      $guide->content = $content;
      $guide->save();
      return response()->json(['message' => 'Guide post updated successfully']);
      
    }

    public function getImages($post_id) {
      $postImages = GuidePostImage::where('guide_post_id', $post_id)->get();
      return response()->json(['data' => $postImages]);
    }

     public function visual($id){
      $guide = GuidePost::findOrFail($id);
      $guide->is_visual = !$guide->is_visual;
      $guide->save();
      return response()->json(['message' => 'Guide post visual status changed successfully', 'is_visual' => $guide->is_visual]);
    } 
}
