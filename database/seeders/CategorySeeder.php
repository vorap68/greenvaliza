<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['title'      => 'Наши путешествия',
                'description' => 'Машиной, самолетом, поездом, велосипедом и пешком…',
                'slug'        => 'nashi-puteshestviya',
                'imageName'       => 'boot_cross',
                'imageExten'       => 'jpg',
            ],
            ['title'      => 'Путеводители',
                'description' => 'Мои мини-путеводители по городам Европы, которые помогут вам составить план своих собственных прогулок',
                'slug'        => 'putevoditeli',
                 'imageName'       => 'meny2-1',
                'imageExten'       => 'jpg',
            ],
            ['title'      => 'Советы и полезности',
                'description' => 'Полезные советы и лайфхаки для тех, кто любит самостоятельные путешествия или отправляется в путешествие впервые…',
                'slug'        => 'sovety-i-poleznosti',
                 'imageName'       => 'sova',
                'imageExten'       => 'jpg',
            ],
            ['title'      => 'Я и мои книги',
                'description' => 'Пишу, редактирую, путешествую, фотографирую, живу…',
                'slug'        => 'ya-i-moi-knigi',
                 'imageName'       => 'book_first',
                'imageExten'       => 'jpg',
            ],
        ]);
        $slugs = Category::pluck('slug')->toArray();
        foreach ($slugs as $slug) {
            $path = storage_path() . '/app/public/images/categories/' . $slug;
            if (! file_exists($path)) {;
                mkdir($path, 0777, true);}
        }
    }
}
