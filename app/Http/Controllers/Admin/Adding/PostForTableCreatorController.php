<?php
namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use App\Models\Posts\TravelPost;
use App\Services\SlugService;
use Illuminate\Http\Request;

/**
 * Контроллер для создания постов, связанных с таблицами в разделе "Путешествия"
 */
class PostForTableCreatorController extends Controller
{
    protected SlugService $slugService;

    /**
     * Конструктор для инициализации сервиса генерации слагов
     */
    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

/**
 * Метод для создания поста, связанного с таблицей в разделе "Путешествия"
 * @param Request $request Объект запроса, содержащий данные для создания поста
    * @return \Illuminate\Http\JsonResponse Ответ в формате JSON с ID созданного поста 
    * для дальнейшего редиректа на страницу редактирования поста
 */
    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'table_id'    => 'required|integer',
        ]);
        $slug = $this->slugService->make($validated['title']);
        $value = [
            'title'       => $validated['title'],
            'slug'        => $slug,
            'description' => $validated['description'] ?? null,
            'table_id'    => $validated['table_id'],
            'content'     => '',
        ];
        $post = TravelPost::create($value);
        if (! $post) {
            return response()->json(['message' => 'Error creating travel post'], 500);
        }
        return response()->json(['post_id' => $post->id]);
    }

}
