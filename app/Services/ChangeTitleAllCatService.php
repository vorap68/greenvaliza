<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeTitleAllCatService
{
    public function changeTitleCatAll( $post,$menuClass, $newTitle)
    {
      
        $oldSlug = $post->slug;
        $newSlug = \Illuminate\Support\Str::slug($newTitle);  
        if ($oldSlug === $newSlug) {
            return;
        }
        // return  $post->$menuClass;
    
         try {
            DB::transaction(function () use ( $post, $newTitle, $newSlug,$menuClass) { 

                //Обновление БД
                //$post->content = $updatedContent;
                $post->title   = $newTitle;
                $post->slug    = $newSlug;
                $post->save();
                $post->$menuClass->title = $newTitle;
                $post->$menuClass->slug = $newSlug;
                $post->$menuClass->save();
               
            });
            return  $post->$menuClass;
        } catch (\Exception $e) {
            
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
