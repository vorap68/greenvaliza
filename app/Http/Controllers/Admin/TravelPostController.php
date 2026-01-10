<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\Posts\TravelPost;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Categories\TravelMenu; 
use App\Models\Images\TravelPostImage;
use App\Http\Resources\TravelPostResource;
use App\Models\Posts\TravelTable;

class TravelPostController extends Controller
{ 
     public function index(){
               $travels = TravelPost::all();
        return TravelResource::collection($travels);
    }

    // public function getMenu(){
    //     $menuItems = TravelMenu::where('type','menus')->get();
    //     return response()->json(['data' => $menuItems]);
    // }

  public function postShow($slug){ 

     $travel = TravelPost::where('slug', $slug)->firstOrFail();
       return new TravelResource($travel);
    }
 
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $travel = TravelPost::findOrFail($id);
      $travel->content = $content;
      $travel->save();
      return response()->json(['message' => 'Travel post updated successfully']);
      
    }

    public function getImages($post_id) {
      $postImages = TravelPostImage::where('travel_post_id', $post_id)->get();
      //dd($postImages);
      return response()->json(['data' => $postImages]); 
    }
   
    public function postCount(){
        $count = TravelPost::count();
        return response()->json(['count' => $count]);
    }

    public function imagesCount(){
        $count = TravelPostImage::count();
        return response()->json(['count' => $count]);
    } 

       public function visual($id){
      $travel = TravelPost::findOrFail($id);
      $travel->is_visual = !$travel->is_visual; 
      $travel->save();
      return response()->json(['message' => 'Travel post visual status changed successfully', 'is_visual' => $travel->is_visual]);
    } 
   

        
}
