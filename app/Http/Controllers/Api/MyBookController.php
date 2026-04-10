<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Models\Categories\MyBookMenu;
use App\Models\Posts\MybookPost;
use Illuminate\Http\Request;

/**
 * Controller for returning  All mybookposts from MyBookMenu , and single post
 * */
class MyBookController extends Controller
{
    /**
     * Return all mybookposts from MyBookMenu where is_visual = 1
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $mybooks = MyBookMenu::where('is_visual', 1)->get();
        return AllPostResource::collection($mybooks);
    }

    /**
     * Return single mybookpost by slug where is_visual = 1
     * @param string $slug Слаг запрашиваемого поста
     * @return AllPostResource
     */
    public function show($slug)
    {
        $mybook = MybookPost::where('slug', $slug)->where('is_visual', 1)->firstOrFail();
        return new AllPostResource($mybook);
    }
}
