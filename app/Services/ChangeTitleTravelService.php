<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeTitleTravelService
{
    public function changeTitleTravel($id, $newTitle): void
    {
        $post = \App\Models\Posts\TravelPost::findOrFail($id);
        $oldSlug = $post->slug;
        $newSlug = \Illuminate\Support\Str::slug($newTitle); 
        if ($oldSlug === $newSlug) {
            return;
        }

    
         try {
          

            DB::transaction(function () use ( $post, $newTitle, $newSlug, $oldSlug) {

                // Обновление контента поста с новыми путями изображений
                // $content        = $post->content;
                // $updatedContent = str_replace("/storage/images/$category/$oldSlug",
                //     "/storage/images/$category/$newSlug", $content);

                //Обновление БД
                //$post->content = $updatedContent;
                $post->title   = $newTitle;
                $post->slug    = $newSlug;
                $post->save();

            });
        } catch (\Exception $e) {
            
             // rollback названия папки при ошибки работы в БД
            // if (is_dir($to)) {
            //     rename($to, $from);
            // }

            Log::error('Change title error',
                [
                  //  'category' => $category,
                    'title'    => $newTitle,
                    'error'    => $e->getMessage(),
                ]);
            throw $e; // ⬅️ ВАЖНО
        }
    }

}
