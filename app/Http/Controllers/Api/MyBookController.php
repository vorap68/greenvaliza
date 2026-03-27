<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Categories\MyBookMenu;
use App\Models\Posts\MybookPost;
use Illuminate\Http\Request;

class MyBookController extends Controller 
{
    public function index(Request $request)
    {
        $mybooks = MyBookMenu::where('is_visual', 1)->get();
     return AllPostResource::collection($mybooks);
    }

      public function show($slug){
      //return response()->json($slug);
        $mybook = MybookPost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
       return new AllPostResource($mybook);
    }
}
