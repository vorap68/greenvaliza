<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeTitleTravelService
{
    public function changeTitleTravelTable($tablePost, $newTitle, )
    {

        $oldSlug = $tablePost->slug;
        $newSlug = \Illuminate\Support\Str::slug($newTitle);
        if ($oldSlug === $newSlug) {
            return;
        }

        try {
            DB::transaction(function () use ($tablePost, $newTitle, $newSlug, $oldSlug) {

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
