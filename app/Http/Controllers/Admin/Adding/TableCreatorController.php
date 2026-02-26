<?php
namespace App\Http\Controllers\Admin\Adding;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SlugService;
use App\Models\Posts\TravelTable;
use App\Http\Controllers\Controller;

class TableCreatorController extends Controller
{

protected SlugService $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }
    
    public function createTable(Request $request, CardCreatorController $cardCreate)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:14096',
        ]);

       $slug = $this->slugService->make($validated['title']); 

  // Создаем запись в главном меню категории - пост-заставку
        // метод из CardCreatorController
        $postCard = $cardCreate->createCard(
               title: $validated['title'],
                slug: $slug,
                description: $validated['description'],
                image: $validated['image'],
                type: 'tble',
        );
        //return response()->json(['tableCreate' => $postCard], 201);

          // Сохряняем изображение на диске и создаем ресайзы
        // метод из CardCreatorController
         $allRezolutions = null;

        if ($request->hasFile('image')) {
            $imageContent = $request->file('image');
             $allRezolutions = $cardCreate->createImage($imageContent, 'travel', $postCard);
        };
        $content = view('travel_table')->render();

        // Создание поста в таблице для категории travelTable
         $value = [
                'title'           => $validated['title'],
                'slug'            => $slug,
                'description'     => $validated['description'],
                'content'         => $content,
                'menu_id'         => $postCard->id,
            ];
               $post = TravelTable::create($value);
            if (! $post) {
                return response()->json(['message' => 'Error creating travel post'], 500);
            }
             return response()->json(['id' => $post->id,'images' => $allRezolutions]);
    }
}
