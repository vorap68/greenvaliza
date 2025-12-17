<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\Posts\GuidePost;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;
use App\Http\Controllers\Controller;
use App\Models\Categories\GuideMenu;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\MyBookMenu;
use App\Models\Categories\TravelMenu;
use Illuminate\Support\Facades\Storage;

class PostCreatorController extends Controller
{

    public function createPost(Request $request,ImageService $imageService)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title'        => 'required|string',
            'description'  => 'nullable|string',
            'category'     => 'required|string',
            'parent_title' => 'nullable|string',
            'image'        => 'nullable|image|max:14096', 
        ]);

        dump($validated);
        $slug = Str::slug($validated['title']);
        dump($slug);
        if($request->hasFile('image')){
           $imageContent =  $request->file('image');
          
           $path ='categoryMenu/'.$validated['category'].'/'.$slug;
           dump($path);

           // Сохраняем оригинальное изображение на диск (1 файл)
           Storage::putFileAs( 'images/'.$path, $imageContent, $imageContent->getClientOriginalName());
           $folderPath = Storage::disk('public')->path("images/categoryMenu/{$validated['category']}/{$slug}");
           dump('folderPath', $folderPath); 


            $source = $folderPath.'/'.$imageContent->getClientOriginalName();
              $imageService->saveResizedImages($source, $path,null);
        }
       
        if ($validated['parent_title'] === null) {
            $this->createMainMenu(
                $validated['title'],
                $slug,
                $validated['description'],
                $validated['category'],
                $validated['image']
            );
              dump('has parent title');
        }
      
        if ($validated['category'] === 'travel') {
            $parent_id = TravelPost::where('title', $validated['parent_title'])->value('id' ?? null); 
            $post      = [
                'title'       => $validated['title'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'parent_id'   => $parent_id ?? null,
                'type'        => 'post',
                'content'     => '',
            ];
            dump('travel post', $post);
            $success = TravelPost::create($post);
            if (! $success) {
                return response()->json(['message' => 'Error creating travel post'], 500);
            }

            return response()->json($post);
        } else {

            // Создание поста в таблице в зависимости от категории
            $model = match ($validated['category']) {
                'guide'  => GuidePost::class,
                'advice' => AdvicePost::class,
                'mybook' => MybookPost::class,
            };
            dump('model', $model);
            $post = $model::create([
                'title'       => $validated['title'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'content'     => '',
            ]);
            if (! $post) {
                return response()->json(['message' => 'Error creating post'], 500);
            }
            return response()->json($post);
        }
    }

    private function createMainMenu($title, $slug, $description, $category,$image)
    {
        $imageName = $image->getClientOriginalName();
       
        $post = [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'type'        => 'posts',
            'imageName'   => pathinfo($imageName, PATHINFO_FILENAME),
            'imageExten'  => $image->getClientOriginalExtension() ,
        ];
        dump('createMainMenu', $post);
        switch ($category) {
            case 'travel':
                TravelMenu::create($post);
                break;
            case 'guide':
                GuideMenu::create($post);
                break;
            case 'advice':
                AdviceMenu::create($post);
                break;
            case 'mybook':
                MyBookMenu::create($post);
                break;
        }
    }
}
