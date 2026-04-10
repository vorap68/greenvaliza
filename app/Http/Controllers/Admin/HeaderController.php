<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;

/**
 * Контроллер для получения данных для отображения на главной странице админки,
 *  таких как количество постов в каждой категории и т.д.
 */
class HeaderController extends Controller
{

    public function countall()
    {
        $single_posts       = TravelPost::where('menu_id', '!=', null)->get();
        $travel_singleposts = count($single_posts);
        $postsAll           = TravelPost::all();
        $countPosts         = count($postsAll);
        $guides             = GuidePost::count();
        $advices            = AdvicePost::count();
        $mybooks            = MybookPost::count();
        $travel_tables      = TravelTable::count();

        return response()->json([
            'posts'              => $countPosts,
            'guides'             => $guides,
            'advices'            => $advices,
            'mybooks'            => $mybooks,
            'travel_tables'      => $travel_tables,
            'travel_singleposts' => $travel_singleposts,
        ]);
    }

}
