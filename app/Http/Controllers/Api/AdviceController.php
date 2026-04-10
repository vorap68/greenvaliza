<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Categories\AdviceMenu;
use App\Models\Posts\AdvicePost;

/**
 * Controller for returning  All adviceposts from AdviceMenu , and single post
 * */
class AdviceController extends Controller
{
    /**
     * Return all adviceposts from AdviceMenu where is_visual = 1
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
             $advices = AdviceMenu::where('is_visual', 1)->get();
                return AllPostResource::collection($advices);
    }

    /**
     * Return single advicepost by slug where is_visual = 1
     * @param string $slug  Слаг запрашиваемого поста
     * @return AllPostResource
     */
    public function show($slug)
    {
        $advice = AdvicePost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
        return new AllPostResource($advice);
    }

}
