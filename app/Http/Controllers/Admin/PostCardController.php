<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdviceResource;
use App\Http\Resources\GuideResource;
use App\Http\Resources\MyBookResource;
use App\Http\Resources\TravelResource;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 *  Работа с меню в админке всех 4-х категорий: guide, travel, advice, mybook
 */
class PostCardController extends Controller
{
    public function index($category_name)
    {
        $postcards = match ($category_name) {
            'travel' => TravelResource::collection(TravelMenu::all()),
            'guide'  => GuideResource::collection(GuideMenu::all()),
            'advice' => AdviceResource::collection(AdviceMenu::all()),
            'mybook' => MyBookResource::collection(MyBookMenu::all()),
        };
        return response()->json($postcards);
    }

    public function show($category_name, $slug)
    {
        // response()->json(['category_name'=>$category_name, 'slug'=>$slug ]);
        $postcard = match ($category_name) {
            'travel' => new TravelResource(TravelMenu::where('slug', $slug)->firstOrFail()),
            'guide'  => new GuideResource(GuideMenu::where('slug', $slug)->firstOrFail()),
            'advice' => new AdviceResource(AdviceMenu::where('slug', $slug)->firstOrFail()),
            'mybook' => new MyBookResource(MyBookMenu::where('slug', $slug)->firstOrFail()),
        };
        return response()->json($postcard);
    }

    public function update(Request $request, $category_name, $slug)
    {

        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:14096',
        ]);

        $postcard = match ($category_name) {
            'travel' => TravelMenu::where('slug', $slug)->firstOrFail(),
            'guide'  => GuideMenu::where('slug', $slug)->firstOrFail(),
            'advice' => AdviceMenu::where('slug', $slug)->firstOrFail(),
            'mybook' => MyBookMenu::where('slug', $slug)->firstOrFail(),
        };

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path         = 'images/categoryMenu/' . $category_name . '/' . $postcard->slug;
            //return  response()->json(['path'=>$path ]); 
            Storage::putFileAs($path, $image, $image->getClientOriginalName());
             $postcard->imageName  = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $postcard->imageExten = $image->getClientOriginalExtension();
            // return response()->json(['imageName'=> $imageName, 'imageExten'=>$imageExten ]);
        }
        $postcard->title       = $validated['title'];
       // $postcard->slug        = Str::slug($validated['title']);
        $postcard->description = $validated['description'];
      

        $postcard->save();

        return response()->json($postcard);
    }
}
