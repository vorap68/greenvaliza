<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MyBookResource;
use App\Models\Categories\MyBookMenu;
use App\Models\Posts\MybookPost;

class MyBookController extends Controller
{
    public function index()
    {
        $mybooks = MyBookMenu::where('is_visual', 1)->get();
     return MyBookResource::collection($mybooks);
    }

      public function show($slug){
      //return response()->json($slug);
        $mybook = MybookPost::where('slug', $slug)->firstOrFail();
       return new MyBookResource($mybook);
    }
}
