<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Images\TravelPostImage;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;

class HeaderController extends Controller
{ 
   
   
    public function countall(){
     // return response()->json(['test' => 'ok']);
        $posts = TravelPost::count();
        $postsAll = TravelPost::all();
        $countPosts = count($postsAll); 
        $guides = GuidePost::count();
        $advices = AdvicePost::count();
        $mybooks = MybookPost::count();
        $travel_tables = TravelTable::count();

        return response()->json([
          'posts' => $countPosts,
           'guides' => $guides,
            'advices' => $advices,
             'mybooks' => $mybooks,
             'travel_tables' => $travel_tables,
            ]);
    }

    public function imagesCount(){
        $count = TravelPostImage::count();
        return response()->json(['count' => $count]);
    } 

     

        
}
