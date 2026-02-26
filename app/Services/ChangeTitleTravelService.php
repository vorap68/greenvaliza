<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\SlugService;


class ChangeTitleTravelService
{
  protected SlugService $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    public function changeTitlePostFinal($finalPost, $newTitle ) 
    {

        $oldSlug = $finalPost->slug;
      $newSlug = $this->slugService->make($newTitle); 
        if ($oldSlug === $newSlug) {
            return;
        }

        try {
            DB::transaction(function () use ($finalPost, $newTitle, $newSlug) { 
            //Обновление БД
                $finalPost->title = $newTitle;
                $finalPost->slug  = $newSlug;
                $finalPost->save();
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

        $oldSlug = $singlePost->slug;
        $newSlug = \Illuminate\Support\Str::slug($newTitle);
        if ($oldSlug === $newSlug) {
            return;
        }

        try {
            DB::transaction(function () use ($singlePost, $newTitle, $newSlug) { 

                //Обновление БД
                $singlePost->title = $newTitle;
                $singlePost->slug  = $newSlug;
                $singlePost->save();
                $singlePost->travelMenu->title = $newTitle;
                $singlePost->travelMenu->slug  = $newSlug;
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

        $oldSlug = $tablePost->slug;
        $newSlug = \Illuminate\Support\Str::slug($newTitle);
        if ($oldSlug === $newSlug) {
            return;
        }

        try {
            DB::transaction(function () use ($tablePost, $newTitle, $newSlug) { 

                //Обновление БД
                $tablePost->title = $newTitle;
                $tablePost->slug  = $newSlug;
                $tablePost->save();
                $tablePost->travelMenu->title = $newTitle;
                $tablePost->travelMenu->slug  = $newSlug;
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
