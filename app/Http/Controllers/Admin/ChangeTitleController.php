<?php
namespace App\Http\Controllers\Admin;

use App\Models\Posts\AdvicePost;
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

    public function update($category_name, $id, Request $request)
    {
        $newTitle = $request->input('title');

        // return response()->json(['title' => $newTitle, 'category' => $category_name, 'id' => $id]);
        if ($category_name === 'travel') {
            $this->serviceTravelCat->changeTitleTravel($id, $newTitle);
        }

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
                $modelClass = \App\Models\Posts\MyBookPost::class;
                $menuClass  = 'mybookMenu';

                break;

            default:
                return response()->json(['message' => 'Invalid category name'], 400);
        }

        $post = $modelClass::with($menuClass)->find($id);
        //return response()->json(['post' => $post]);
       // $postAdviceMenu = $post->$menuClass;
    //    $postMenu = $post->$menuClass;
    //    return response()->json(['postMenu' => $postMenu]);
        if (! $post) {
            return response()->json(['message' => 'Post not found'], 404); 
        }

        //return response()->json(['post' => $post->$menuClass]);
        // Вызов сервиса для изменения путей
        $result = $this->serviceAllCat->changeTitleCatAll($category_name, $post,$menuClass, $newTitle);

        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);
    }
}
