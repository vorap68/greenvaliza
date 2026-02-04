<?php
namespace App\Http\Controllers\Admin;

use App\Models\Posts\AdvicePost;
use App\Models\Posts\TravelTable;
use App\Services\ChangeTitleAllCatService;
use App\Services\ChangeTitleTravelService;
use Illuminate\Http\Request;

class ChangeTitleController 
{

    protected $serviceAllCat;
    protected $serviceTravelCat;

    public function __construct(ChangeTitleAllCatService $serviceAllCat,
        ChangeTitleTravelService $serviceTravelCat) {
        $this->serviceAllCat    = $serviceAllCat;
        $this->serviceTravelCat = $serviceTravelCat;
    }

    public function updateAllCat($category_name, $id, Request $request)
    {
        $newTitle = $request->input('title');

       // return response()->json(['title' => $newTitle, 'category' => $category_name, 'id' => $id]);

        // Логика изменения заголовка в зависимости от категории
        switch ($category_name) {
            case 'guide':
                $modelClass = \App\Models\Posts\GuidePost::class;
                $menuClass  = 'guideMenu';
                break;
            case 'advice':
                $modelClass = AdvicePost::class;
                $menuClass  = 'adviceMenu';

                break;
            case 'mybook':
                $modelClass = \App\Models\Posts\MybookPost::class;
                $menuClass  = 'mybookMenu';
                break;
            default:
                return response()->json(['message' => 'Invalid category name'], 400); 
        }

        $post = $modelClass::with($menuClass)->find($id);
    
        //return response()->json(['post' => $post]);
       
          // $postMenu = $post->$menuClass;
          //  return response()->json(['postMenu' => $postMenu]);
        if (! $post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        //return response()->json(['post' => $post->$menuClass]);
        // Вызов сервиса для изменения путей
        $result = $this->serviceAllCat->changeTitleCatAll( $post, $menuClass, $newTitle);
        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);
    }

    public function updateTravelTable($id, Request $request)
    {
        $newTitle  = $request->input('title');
        $tablePost = TravelTable::with('travelMenu')->find($id);
        $result    = $this->serviceTravelCat->changeTitleTravelTable($tablePost, $newTitle);

        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);

    }

    public function updateTravelPost($id, Request $request)
    {
        $newTitle = $request->input('title');

        $finalPost = TravelTable::with('travelPosts')->find($id);
        return response()->json(['finalPost' => $finalPost]);

    }
}
