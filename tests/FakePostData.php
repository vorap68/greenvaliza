<?php

namespace Tests;

use Faker\Factory;
use App\Models\Categories\TravelMenu;
use App\Models\Posts\TravelTable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FakePostData
{

    private static function getFaker()
    {
      $path = base_path('tests/Feature/sova.jpg');
        $file = new UploadedFile(
            $path,
            'avatar.jpg',
            'image/jpeg',
            null,
            true // Включает тестовый режим (test mode)
        );
        $faker = Factory::create();
        // dd($file);
        $title = $faker->sentence(3);
         $slug =  Str::slug($title);
          $description = $faker->paragraph();
        return [
            'title' => $title ,
            'slug' => $slug,
            'description' => $description,
            'image' => $file,
        ];
    }

    public static function getFakeTravelPostForTable(string $parentTitle): array
    {
        $table = TravelTable::where('slug', $parentTitle)->firstOrFail();
        $table_id = $table->id;
        $post_data = array_merge(
            self::getFaker(),
            [
                'table_id' => $table_id,
                'category' => 'travel',
                'parentTitle' => $parentTitle,
                //  'image': $validated['image'],
            ]
        );
        return $post_data;
    }
    public static function getFakeSimplePost(string $cat_name): array
    {
        $post_data = array_merge(
            self::getFaker(),
            [
                'category' => $cat_name,
                //  'image': $validated['image'],
            ]
        );
        return $post_data;
    }
}
