<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 *  Сервис для изменения заголовков в категориях (guide, advice, mybook) в админке
 *  Этот сервис отвечает за обновление заголовков постов и связанных с ними меню
 *  при изменении названия поста в админке. Он обеспечивает целостность данных и корректное
 * обновление всех связанных записей в базе данных, используя транзакции для обеспечения атомарности операций.
 *
 */
class ChangeTitleAllCatService
{

/**
 * @param object $post          Модель поста, который нужно обновить
 * @param  string $menuClass      Название связи для доступа к меню (guideMenu, adviceMenu, mybookMenu)
 * @param  string $newTitle       Новый заголовок для поста и меню
 * @return \Illuminate\Database\Eloquent\Model  Обновленная модель меню после изменения заголовка
 * @throws \Exception  Исключение, если возникает ошибка при обнов
 */
    public function changeTitleCatAll($post, $menuClass, $newTitle)
    {

        try {
            DB::transaction(function () use ($post, $newTitle, $menuClass) {

                //Обновление БД
                $post->title = $newTitle;
                $post->save();
                $post->$menuClass->title = $newTitle;
                $post->$menuClass->save();
            });
            return $post->$menuClass;
        } catch (\Exception $e) {

            Log::error('Change title error',
                [
                    'title' => $newTitle,
                    'error' => $e->getMessage(),
                ]);
            throw $e;
        }
    }

}
