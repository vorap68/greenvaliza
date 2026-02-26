<?php
namespace App\Http\Controllers\Admin\ChangeTitle;

use Illuminate\Http\Request;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Services\ChangeTitleAllCatService;
use App\Services\ChangeTitleTravelService;

class TitleAllCategoryController 
{

    protected $serviceAllCat;
    protected $serviceTravelCat;

    public function __construct(ChangeTitleAllCatService $serviceAllCat) 
    {
        $this->serviceAllCat    = $serviceAllCat;
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
       if (! $post) {
            return response()->json(['message' => 'Post not found'], 404); 
        }

        // Вызов сервиса для изменения путей
        $result = $this->serviceAllCat->changeTitleCatAll( $post, $menuClass, $newTitle);
        return response()->json(['message' => 'Title changed successfully', 'data' => $result]);
    }

    
   
}
