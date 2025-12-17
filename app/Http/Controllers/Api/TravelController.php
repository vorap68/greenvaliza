<?php

namespace App\Http\Controllers\Api;



use App\Models\Posts\TravelPost;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Categories\TravelMenu; 


class TravelController extends Controller
{ 
     public function index(){
        
       $travels = TravelMenu::all();
       //return response()->json($travels);
        return TravelResource::collection($travels);
    }

  public function show($slug){ 
     $travel = TravelPost::where('slug', $slug)->firstOrFail();
       return new TravelResource($travel);
    }
  
   
}
