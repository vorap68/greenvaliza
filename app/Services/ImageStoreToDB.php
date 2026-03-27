<?php
namespace App\Services;

use App\Models\Images\Images;

class ImageStoreToDB
{
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

        Images::insertOrIgnore($records);
    }
}
