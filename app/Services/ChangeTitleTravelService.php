<?php
namespace App\Services;

use App\Models\Posts\TravelTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Сервис для изменения заголовков в категории travel в админке 
 * для каждого типа постов в категории travel 
 *  есть свой метод для изменения заголовков, который вызывается из контроллера TitleTravelController
 */
class ChangeTitleTravelService
{

/**
 * метод для обновления заголовка поста в категории travel для компонента post single
 * @param  object  $finalPost  пост для обновления
 * @param  string $newTitle новый заголовок для поста
 * @param  object  $finalPost  пост для обновления
 * @return   обновленный пост с новым заголовком
 */
    public function changeTitlePostFinal($finalPost, $newTitle )  
    {

        try {
            DB::transaction(function () use ($finalPost, $newTitle) { 
            //Обновление БД
             $oldTitle = $finalPost->title;
                $finalPost->title = $newTitle;
               $finalPost->save();
                $travelTable = TravelTable::find($finalPost->table_id);
                // Обновляем title в таблице НО в тблице часто более полное имя 
                //например  в таблице "Парки львова" есть пост 
                //Ботанический сад Львовского лесотехнического университета
                //а в БД его имя "Ботанический сад "
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


    /**
     * метод для обновления заголовка таблицы в категории travel для компонента table
     * @param  object  $singlePost  таблица для обновления
     * @param  string $newTitle новый заголовок для таблицы
     * @return   обновленная таблица с новым заголовком 
     */
    public function changeTitlePostSingle($singlePost, $newTitle )
    {
      
        try {
            DB::transaction(function () use ($singlePost, $newTitle) { 

                //Обновление БД
                $singlePost->title = $newTitle;
                $singlePost->save();
                $singlePost->travelMenu->title = $newTitle;
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

    /**
     * метод для обновления заголовка таблицы в категории travel для компонента table
     * @param  object  $tablePost  таблица для обновления
     * @param  string $newTitle новый заголовок для таблицы
     * @return   обновленная таблица с новым заголовком
     */
    public function changeTitleTable($tablePost, $newTitle ) 
    {

        try {
            DB::transaction(function () use ($tablePost, $newTitle) { 

                //Обновление БД
                $tablePost->title = $newTitle;
                $tablePost->save();
                $tablePost->travelMenu->title = $newTitle;
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
