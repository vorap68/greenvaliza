<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Categories\GuideMenu;
use App\Models\Posts\GuidePost;

/**
 * Controller for returning  All guideposts from GuideMenu , and single post
 * */
class GuideController extends Controller
{
    /**
     * Return all guideposts from GuideMenu where is_visual = 1
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $guides = GuideMenu::where('is_visual', 1)->get();
        return AllPostResource::collection($guides);
    }

    /**
     * Return single guidepost by slug where is_visual = 1
     * @param string $slug Слаг запрашиваемого поста
     * @return AllPostResource
     */
    public function show($slug)
    {
        $guide = GuidePost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
        return new AllPostResource($guide);
    }

}
