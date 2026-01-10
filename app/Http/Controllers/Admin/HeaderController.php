<?php

namespace App\Http\Controllers\Admin;


use App\Models\Posts\TravelPost;
use App\Http\Controllers\Controller;
use App\Models\Images\TravelPostImage;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use App\Models\Posts\MybookPost;

class HeaderController extends Controller
{ 
   
   
    public function countall(){
     // return response()->json(['test' => 'ok']);
        $posts = TravelPost::count();
        $guides = GuidePost::count();
        $advices = AdvicePost::count();
        $mybooks = MybookPost::count();

        return response()->json([
          'posts' => $posts,
           'guides' => $guides,
            'advices' => $advices,
             'mybooks' => $mybooks,
            ]);
    }

    public function imagesCount(){
        $count = TravelPostImage::count();
        return response()->json(['count' => $count]);
    } 

     

        
}
