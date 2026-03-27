<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostResource;
use App\Http\Resources\TravelResource;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 *  Работа с меню в админке всех 4-х категорий: guide, travel, advice, mybook
 */
class PostCardController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        

    }

    public function index($category_name)
    {
        $postcards = match ($category_name) {
            'travel' => TravelResource::collection(TravelMenu::all()),
            'guide'  => AllPostResource::collection(GuideMenu::all()),
            'advice' => AllPostResource::collection(AdviceMenu::all()),
            'mybook' => AllPostResource::collection(MyBookMenu::all()),
        };
        return response()->json($postcards);
    }

    public function visual($category_name, $id)
    {
       $postcard = $this->getPostCard($category_name, $id);
        //return response()->json(['current_post  ' => $postcard]);
        $postcard->is_visual = ! $postcard->is_visual;
        $postcard->save();

        return response()->json(['is_visual' => $postcard->is_visual]);
    }


    public function show($category_name, $id)
    {
        response()->json(['category_name' => $category_name, 'id' => $id]);
        $postcard = match ($category_name) {
            'travel' => new TravelResource(TravelMenu::where('id', $id)->firstOrFail()),
            'guide'  => new AllPostResource(GuideMenu::where('id', $id)->firstOrFail()),
            'advice' => new AllPostResource(AdviceMenu::where('id', $id)->firstOrFail()),
            'mybook' => new AllPostResource(MyBookMenu::where('id', $id)->firstOrFail()),
        };
        return response()->json($postcard);
    }

    public function update(Request $request, $category_name, $id)
    {

        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:14096',
        ]);

        $postcard = $this->getPostCard($category_name, $id);

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $path       = 'images/categoryMenu/' . $category_name . '/' . $postcard->id . '/original';
            $fileName   = $image->getClientOriginalName();
            $fullPath[] = Storage::disk('public')->path(
                "{$path}/{$fileName}"
            );
            //return  response()->json(['path'=>$path ]);
            Storage::putFileAs($path, $image, $fileName);
            $successResize       = $this->imageService->saveResizedImages($fullPath, null);
            $postcard->imageName = $fileName;
            // return response()->json(['imageName'=> $imageName, 'imageExten'=>$imageExten ]);
        }
        $postcard->title = $validated['title'];
        $postcard->description = $validated['description'];
        $postcard->save();
// return response()->json(['successResize' => $successResize]);
        return response()->json($postcard);
    }

    private function getPostCard($category_name,$id) 
    {
      $postcard = match ($category_name) {
            'travel' => TravelMenu::where('id', $id)->firstOrFail(),
            'guide'  => GuideMenu::where('id', $id)->firstOrFail(),
            'advice' => AdviceMenu::where('id', $id)->firstOrFail(),
            'mybook' => MyBookMenu::where('id', $id)->firstOrFail(),
        };
        return $postcard;
    }
}
