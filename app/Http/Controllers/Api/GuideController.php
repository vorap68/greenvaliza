<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Models\Posts\GuidePost;
use App\Http\Controllers\Controller;
use App\Models\Categories\GuideMenu;
use App\Http\Resources\GuideResource;


class GuideController extends Controller  

{
    public function index(){
       
       $guides = GuideMenu::where('is_visual', 1)->get();
      return GuideResource::collection($guides);
    }

      public function show($slug){
      //return response()->json($slug);
        $guide = GuidePost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
       return new GuideResource($guide);
    }
  
  
}
