<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Posts\AdvicePost;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdviceResource;
use App\Models\Images\AdvicePostImage;

/**
 * Работа с советами и полезностями в админке
 */
class AdviceController extends Controller
{
    public function index()
    {

        $advices = AdvicePost::orderBy('id', 'asc')->get();
        //dd($guide);
        return AdviceResource::collection($advices);
    }
    public function show($id)
    {
        $advice = AdvicePost::findOrFail($id);
        return new AdviceResource($advice);
    }

    public function update(Request $request, $id)
    {
        $content = $request->input('content');
        $advice = AdvicePost::findOrFail($id);
        $advice->content = $content;
        $advice->save();
        return response()->json(['message' => 'advice post updated successfully']);
    }



    public function getImages($post_id)
    {
        $postImages = AdvicePostImage::where('advice_post_id', $post_id)->get();
        return response()->json(['data' => $postImages]);
    }

    public function visual($id)
    {
        $advice            = AdvicePost::findOrFail($id);
        $advice->is_visual = ! $advice->is_visual;
        $advice->save();
        return response()->json(['message' => 'Advice post visual status changed successfully', 'is_visual' => $advice->is_visual]);
    }
}
