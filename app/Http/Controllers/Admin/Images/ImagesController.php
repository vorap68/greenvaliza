<?php
namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use App\Models\Images\Images;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
     //Возвращает фото для опред категории , для админ->фото->категории
  public function categoryImages($category)
    {
       $imagesData = [];   
        $imagesData = Images::where('category', $category)->paginate(20);
        return response()->json(['imageData' => $imagesData
       ]);
    }


    //Возвращает фото выбраного поста для опред категории
    //Для админ->посты
  public function postCategoryImages($category,$id)
    {
       $imagesData = [];   
        $imagesData = Images::where(['category'=> $category,'post_id'=>$id])->paginate(20);
        return response()->json(['imageData' => $imagesData
       ]);
    }
    
      //Возвращает фото для карточек меню опред категории , для админ-фото
    public function CardMenuImages($categoryCard)
    {
        $imagesCard = [];   
        //dd($categoryCard);
        $imagesCard = match ($categoryCard) {
            'travel' => TravelMenu::select('id','imageName')->get(),
            'guide'  => GuideMenu::select('id','imageName')->get(),
            'advice' => AdviceMenu::select('id','imageName')->get(),
            'mybook' => MyBookMenu::select('id','imageName')->get(),
        };
        return response()->json($imagesCard);
      
    }

    //поиск фото по именим
         public function imageSearch(Request $request)
    { 
        $query = Images::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query  = $query->select('category','post_id','filethumb','filename')->where('filename', 'like', "%{$search}%")->get();
        }
       
        return response()->json(['data'=>$query]);
    }
   
}
