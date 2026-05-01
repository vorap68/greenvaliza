<?php
namespace App\Services;

use App\Models\Images\Images;

/** 
 * Сервис для сохранения имени файлов изображениях в базе данных
 * Тех что добавляются через админку при загрузке изображений к посту
 */
class ImageStoreToDB
{
    /** 
     * Метод для сохранения информации об изображениях в базе данных
     * @param array $fileNameArray
     * @param int $post_id
     * @param string $category_name
     * @return void
     */
    public function imageStoreDb($fileNameArray, $post_id, $category_name)
    {
        $records = [];

        foreach ($fileNameArray as $fileName) {
            $fullName  = pathinfo($fileName);
            $thumbname = $fullName['filename'] . '_600.' . $fullName['extension'];
            $records[] = [
                'post_id'    => $post_id,
                'category'   => $category_name,
                'filename'   => $fileName,
                'filethumb'  => $thumbname,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return Images::insertOrIgnore($records);
    }
}
