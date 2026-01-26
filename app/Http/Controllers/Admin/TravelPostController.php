<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Images\TravelPostImage;
use App\Models\Posts\TravelPost;
use Illuminate\Http\Request;

class TravelPostController extends Controller
{
    public function index(Request $request)
    {
        if($request->all()===[]) return TravelResource::collection(TravelPost::all());
       
        $query = TravelPost::query();
        if ($request->has('search')) {
            $search  = $request->input('search');
            $query = $query->where('title', 'like', "%{$search}%");
        }
        $query = $query->orderBy($request->sort_by,$request->sort_dir) ;
        return TravelResource::collection($query->paginate(10));
    }


    public function postShow($slug)
    {

        $travel = TravelPost::where('slug', $slug)->firstOrFail();
        return new TravelResource($travel);
    }

    public function update(Request $request, $id)
    {

        $content = $request->input('content');

        $travel          = TravelPost::findOrFail($id);
        $travel->content = $content;
        $travel->save();
        return response()->json(['message' => 'Travel post updated successfully']);

    }

    public function getImages($post_id)
    {
        $postImages = TravelPostImage::where('travel_post_id', $post_id)->get();
        //dd($postImages);
        return response()->json(['data' => $postImages]);
    }

  

    public function visual($id)
    {
        $travel            = TravelPost::findOrFail($id);
        $travel->is_visual = ! $travel->is_visual;
        $travel->save();
        return response()->json(['message' => 'Travel post visual status changed successfully', 'is_visual' => $travel->is_visual]);
    }

}
