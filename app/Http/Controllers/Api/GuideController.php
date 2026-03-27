<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Categories\GuideMenu;
use App\Models\Posts\GuidePost;


class GuideController extends Controller  

{
    public function index(){
       
       $guides = GuideMenu::where('is_visual', 1)->get();
      return AllPostResource::collection($guides);
    }

      public function show($slug){
      //return response()->json($slug);
        $guide = GuidePost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
       return new AllPostResource($guide);
    }
  
  
}
