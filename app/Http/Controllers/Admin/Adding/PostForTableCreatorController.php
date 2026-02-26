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

class PostForTableCreatorController extends Controller  
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
             'table_id' => 'required|integer',
           ]);
          
          $slug = $this->slugService->make($validated['title']); 
           
            $value = [
                'title'           => $validated['title'],
                'slug'            => $slug,
                'description'     => $validated['description'] ?? null,
                'table_id' => $validated['table_id'],
                'content'         => '',
            ];
           $post = TravelPost::create($value);
            if (! $post) {
                return response()->json(['message' => 'Error creating travel post'], 500);
            }
            //return response()->json($post);
     

            return response()->json(['id' => $post->id]);
        }
    

}
