<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Categories\TravelMenu;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Services\TravelContentParser;

/**
 * Controller for returning  All travelposts from TravelMenu , single post, and single table
 * */
class TravelController extends Controller
{
     /**
     * Return all travelposts from TravelMenu where is_visual = 1
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $travels = TravelMenu::where('is_visual', 1)->get();
        //return response()->json($travels);
        return TravelResource::collection($travels);
    }


      /**
     * Return single travelpost by slug where is_visual = 1
     * @param string $slug  Слаг запрашиваемого поста
     * @return App\Http\Resources\AllPostResource
     */
    public function postShow($slug)
    {
      $travel = TravelPost::where('slug', $slug)->where('is_visual', 1)->firstOrFail(); 
      return new TravelResource($travel);
    }


      /**
     * Return single traveltable by slug where is_visual = 1
     * @param string $slug  Слаг запрашиваемой таблицы
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableShow($slug)
    {
        $travel = TravelTable::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
        return response()->json([
          'id'    => $travel->id,
          'title' => $travel->title,
          'slug'  => $travel->slug,
          'content' => TravelContentParser::parse($travel->content),
        ]);
       
    }

}
