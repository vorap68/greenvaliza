<?php
namespace App\Http\Controllers\Api;

use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Http\Controllers\Controller;
use App\Models\Categories\TravelMenu;
use App\Services\TravelContentParser;
use App\Http\Resources\TravelResource;

class TravelController extends Controller
{
    public function index()
    {
        $travels = TravelMenu::where('is_visual', 1)->get();
        //return response()->json($travels);
        return TravelResource::collection($travels);
    }

    public function postShow($slug)
    {
      $travel = TravelPost::where('slug', $slug)->where('is_visual', 1)->firstOrFail(); 
      return new TravelResource($travel);
    }


    public function tableShow($slug)
    {
       // return response()->json(['slug'=> $slug]);
        $travel = TravelTable::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
        // return response()->json(TravelContentParser::parse($travel->content), 200);
        return response()->json([
          'id'    => $travel->id,
          'title' => $travel->title,
          'slug'  => $travel->slug,
          'content' => TravelContentParser::parse($travel->content),
        ]);
       
    }

}
