<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Models\Posts\TravelTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TableCreatorController extends Controller
{
    public function createTable(Request $request, CardCreatorController $cardCreate)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:14096',
        ]);

        $slug = Str::slug($validated['title']);

        // Сохряняем изображение на диске и создаем ресайзы
        // метод из CardCreatorController
        if ($request->hasFile('image')) {
            $imageContent = $request->file('image');
            $cardCreate->createImage($imageContent, $slug);
        };

        // Создаем запись в главном меню категории - пост-заставку
        // метод из CardCreatorController
        $response = $cardCreate->createCard(
            title: $validated['title'],
            slug: $slug,
            description: $validated['description'],
            image: $validated['image'],
            type: 'menus',
        );
        //return response()->json(['tableCreate' => $response], 201);

        // Создание поста в таблице для категории travelTable
         $post = [
                'title'           => $validated['title'],
                'slug'            => $slug,
                'description'     => $validated['description'],
                'content'         => '',
            ];
               $success = TravelTable::create($post);
            if (! $success) {
                return response()->json(['message' => 'Error creating travel post'], 500);
            }
            return response()->json($post);
    }
}
