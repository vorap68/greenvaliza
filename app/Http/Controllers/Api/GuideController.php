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
         //return response()->json('77777');
       $guides = GuideMenu::all();
      return GuideResource::collection($guides);
    }

      public function show($slug){
      //return response()->json($slug);
        $guide = GuidePost::where('slug', $slug)->firstOrFail();
       return new GuideResource($guide);
    }
  
  
}
