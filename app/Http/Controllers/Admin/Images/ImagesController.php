<?php
namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use App\Models\Images\Images;
use Illuminate\Http\Request;


/**
 * Контроллер для работы с изображениями в админке
 */
class ImagesController extends Controller
{
    /**
     * 
     * метод для получения всех фото определенной категории для админки->фото
     * @param  string $category  категория для получения фото
     * @return \Illuminate\Http\JsonResponse
     */
     
  public function categoryImages($category)
    {
       $imagesData = [];   
        $imagesData = Images::where('category', $category)->paginate(20);
        return response()->json(
            ['imageData' => $imagesData
       ]);
    }


    /**
     * Возвращает фото выбраного поста для опред категории  для админ->посты
     * @param  string $category  категория для получения фото
     * @param  int $id  ID поста для получения фото
     * @return \Illuminate\Http\JsonResponse
     */
  public function postCategoryImages($category,$id)
    {
       $imagesData = [];   
        $imagesData = Images::where(['category'=> $category,'post_id'=>$id])->paginate(20);
        return response()->json(['imageData' => $imagesData
       ]);
    }
    
      
    /**
     * Возвращает фото для карточек меню опред категории , для админ-фото
     * @param  string $categoryCard  категория для получения фото
     * @return \Illuminate\Http\JsonResponse
     */
    public function CardMenuImages($categoryCard)
    {
        $imagesCard = [];   
        $imagesCard = match ($categoryCard) {
            'travel' => TravelMenu::select('id','imageName')->get(),
            'guide'  => GuideMenu::select('id','imageName')->get(),
            'advice' => AdviceMenu::select('id','imageName')->get(),
            'mybook' => MyBookMenu::select('id','imageName')->get(),
        };
        return response()->json($imagesCard);
      
    }

    /**
     * поиск фото по именим
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
