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

class TravelTableController extends Controller
{ 
     public function index(){
               $traveltables = TravelTable::all();
        return TravelResource::collection($traveltables);
    }

   

  
  public function tableShow($slug){ 
     // return response()->json(['slug' => $slug]);
     $traveltable = TravelTable::where('slug', $slug)->firstOrFail();
   // return response()->json(['data' => $travel]);
       return new TravelResource($traveltable);
    }
  
    public function update( Request $request,  $id ){
           
      $content = $request->input('content');
    
      $traveltable = TravelTable::findOrFail($id);
      $traveltable->content = $content;
      $traveltable->save();
      return response()->json(['message' => 'Travel traveltable updated successfully']);
      
    }

    public function getImages($post_id) {
      $traveltable = TravelPostImage::where('travel_post_id', $post_id)->get();
      return response()->json(['data' => $traveltable]);
    }
   
  

       public function visual($id){
       
      $traveltable = TravelTable::findOrFail($id);
      $traveltable->is_visual = !$traveltable->is_visual; 
      $traveltable->save();
      return response()->json(['message' => 'Travel table visual status changed successfully', 'is_visual' => $traveltable->is_visual]);
    } 
   

        
}
