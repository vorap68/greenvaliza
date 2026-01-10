<?php

namespace App\Http\Controllers\Api;



use Illuminate\Http\Request;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Http\Controllers\Controller;
use App\Models\Categories\TravelMenu;
use App\Http\Resources\TravelResource;

class TravelController extends Controller
{ 
     public function index(Request $request){
    $travels = TravelMenu::where('is_visual', 1)->get();
              return TravelResource::collection($travels);
    }

  // public function show($slug){ 
  //    $travel = TravelPost::where('slug', $slug)->firstOrFail();
  //      return new TravelResource($travel);
  //   }

      public function postShow($slug){ 

     $travel = TravelPost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
       return new TravelResource($travel);
    }
  public function tableShow($slug){ 
     $travel = TravelTable::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
       return new TravelResource($travel);
    }
  
   
}
