<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdviceResource;
use App\Models\Categories\AdviceMenu;
use App\Models\Posts\AdvicePost;

class AdviceController extends Controller
{
    public function index()
    {
        $advices = AdviceMenu::all();
        // dd($advices);
        return AdviceResource::collection($advices);
    }

    public function show($slug)
    {
        //return response()->json($slug);
        $advice = AdvicePost::where('slug', $slug)->firstOrFail();
        return new AdviceResource($advice);
    }

}
