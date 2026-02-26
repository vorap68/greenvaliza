<?php
namespace App\Http\Controllers\Admin\Adding;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SlugService;
use App\Models\Posts\GuidePost;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use App\Http\Controllers\Controller;

use function PHPSTORM_META\type;

class PostSingleCreatorController extends Controller  
{
 protected SlugService $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }


    public function createPost(Request $request, CardCreatorController $cardCreate) 
    {
        $validated = $request->validate([
            'title'        => 'required|string',
            'description'  => 'nullable|string',
            'category'     => 'required|string',
            'parent_title' => 'nullable|string',
            'image'        => 'nullable|image|max:14096',
        ]);
          
          $slug = $this->slugService->make($validated['title']); 
           //return response()->json(['validated' => $validated]);  
            // Создаем запись в главном меню категории - пост-заставку
             //Со всеми фото + копии для всех разрешений. И сохраняем  все фото в файловой  системе
            // метод из CardCreatorController
            $postMenu = $cardCreate->createCard(
                title: $validated['title'],
                slug: $slug,
                description: $validated['description'],
                image: $validated['image'],
                category: $validated['category'],
                type: 'post'
            );
           // return response()->json(['card_after_Create' => $postMenu]);
              // Сохряняем изображение на диске и создаем ресайзы
            // метод из CardCreatorController
             $allRezolutions =null;
            if ($request->hasFile('image')) {
               // return response()->json(['message' => 'Image file received']);
                $imageContent = $request->file('image');
               $allRezolutions = $cardCreate->createImage($imageContent, $validated['category'], $postMenu);
            };
            //return response()->json(['message' => 'No image file provided']);
        
     // Создание поста в таблице. 
            $model = match ($validated['category']) {
                'travel'  => TravelPost::class,
                'guide'  => GuidePost::class,
                'advice' => AdvicePost::class,
                'mybook' => MybookPost::class,
            };
           
          //return response()->json(['model' => $model,'cardCreate' => $postMenu]);
            $post = $model::create([
                'title'       => $validated['title'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'content'     => '',
                'menu_id'     => $postMenu->id ?? null,
            ]);
            if (! $post) {
                return response()->json(['message' => 'Error creating post (controller)'], 500);
            }

            return response()->json(['id' => $post->id,'images' => $allRezolutions]);
        
    }

}
