<?php
namespace App\Services;

use App\Models\Posts\TravelTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class ChangeTitleTravelService
{
// Я убрал изменение слага при изменении названия поста
//   protected SlugService $slugService;

//     public function __construct(SlugService $slugService)
//     {
//         $this->slugService = $slugService;
//     }

    public function changeTitlePostFinal($finalPost, $newTitle ) 
    {

    //     $oldSlug = $finalPost->slug;
    //   $newSlug = $this->slugService->make($newTitle); 
    //     if ($oldSlug === $newSlug) {
    //         return;
    //     }
       
        try {
            DB::transaction(function () use ($finalPost, $newTitle) { 
            //Обновление БД
             $oldTitle = $finalPost->title;
                $finalPost->title = $newTitle;
                // $finalPost->slug  = $newSlug;
                $finalPost->save();
              
                $travelTable = TravelTable::find($finalPost->table_id);
                $contentTable = $travelTable->content;
                $updatedContent = str_replace($oldTitle, $newTitle, $contentTable);
                $travelTable->content = $updatedContent;
                $travelTable->save();
                  });
            return $finalPost;
        } catch (\Exception $e) {
            Log::error('Change title error',
                [
                    'title' => $newTitle,
                    'error' => $e->getMessage(),
                ]);
            throw $e; // ⬅️ ВАЖНО
        }
    }

    public function changeTitlePostSingle($singlePost, $newTitle )
    {

        // $oldSlug = $singlePost->slug;
        // $newSlug = \Illuminate\Support\Str::slug($newTitle);
        // if ($oldSlug === $newSlug) {
        //     return;
        // }

        try {
            DB::transaction(function () use ($singlePost, $newTitle) { 

                //Обновление БД
                $singlePost->title = $newTitle;
                // $singlePost->slug  = $newSlug;
                $singlePost->save();
                $singlePost->travelMenu->title = $newTitle;
                // $singlePost->travelMenu->slug  = $newSlug;
                $singlePost->travelMenu->save();

            });
            return $singlePost->travelMenu;
        } catch (\Exception $e) {
            Log::error('Change title error',
                [
                    'title' => $newTitle,
                    'error' => $e->getMessage(),
                ]);
            throw $e; // ⬅️ ВАЖНО
        }
    }
    public function changeTitleTable($tablePost, $newTitle ) 
    {

        // $oldSlug = $tablePost->slug;
        // $newSlug = \Illuminate\Support\Str::slug($newTitle);
        // if ($oldSlug === $newSlug) {
        //     return;
        // }

        try {
            DB::transaction(function () use ($tablePost, $newTitle) { 

                //Обновление БД
                $tablePost->title = $newTitle;
                // $tablePost->slug  = $newSlug;
                $tablePost->save();
                $tablePost->travelMenu->title = $newTitle;
               // $tablePost->travelMenu->slug  = $newSlug;
                $tablePost->travelMenu->save();

            });
            return $tablePost->travelMenu;
        } catch (\Exception $e) {
            Log::error('Change title error',
                [
                    'title' => $newTitle,
                    'error' => $e->getMessage(),
                ]);
            throw $e; // ⬅️ ВАЖНО
        }
    }

}
