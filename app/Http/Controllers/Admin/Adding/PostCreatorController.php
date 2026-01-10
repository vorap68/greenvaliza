<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostCreatorController extends Controller
{

    public function createPost(Request $request,  CardCreatorController $cardCreate )
    {
        // dd($request->all());
        $validated = $request->validate([
            'title'        => 'required|string', 
            'description'  => 'nullable|string',
            'category'     => 'required|string',
            'parent_title' => 'nullable|string',
            'image'        => 'nullable|image|max:14096',
        ]);

        $slug = Str::slug($validated['title']);

        // Если нет родительского заголовка, создаем пост-заставку-превью
        if ($validated['parent_title'] === null) {
            // Сохряняем изображение на диске и создаем ресайзы
            // метод из CardCreatorController
            if ($request->hasFile('image')) {   
                 $imageContent = $request->file('image');
                $cardCreate->createImage( $imageContent, $validated['category'], $slug);   
            };
        

            // Создаем запись в главном меню категории - пост-заставку
            // метод из CardCreatorController
           $cardCreate->createCard(
                $validated['title'],
                $slug,
                $validated['description'],
                $validated['category'],
                $validated['image']
            );

        };

        // Создание поста в таблице для категории travel
        if ($validated['category'] === 'travel') {
            $parent_id = TravelTable::where('title', $validated['parent_title'])->value('id' ?? null);
           //return response()->json(['parent_id' => $parent_id]);
            $post      = [
                'title'       => $validated['title'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'travel_table_id'   => $parent_id ?? null,
                 'content'     => '',
            ];
            $success = TravelPost::create($post);
            if (! $success) {
                return response()->json(['message' => 'Error creating travel post'], 500);
            }
            return response()->json($post);
        } else {
            // Создание поста в таблице  категории кроме travel
            $model = match ($validated['category']) {
                'guide'  => GuidePost::class,
                'advice' => AdvicePost::class,
                'mybook' => MybookPost::class,
            };
            $post = $model::create([
                'title'       => $validated['title'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'content'     => '',
            ]);
            if (! $post) {
                return response()->json(['message' => 'Error creating post'], 500);
            }

            return response()->json(['slug' => $slug]);
        }
    }

   
}
