<?php
namespace Database\Seeders;

use App\Models\Category\Categories\Category;
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
                'name' => 'travel',
                'description' => 'Машиной, самолетом, поездом, велосипедом и пешком…',
                'slug'        => 'nashi-puteshestviya',
                'imageName'       => 'boot_cross',
                'imageExten'       => 'jpg',
            ],
            ['title'      => 'Путеводители',
            'name' => 'guide',
                'description' => 'Мои мини-путеводители по городам Европы, которые помогут вам составить план своих собственных прогулок',
                'slug'        => 'putevoditeli',
                 'imageName'       => 'meny2-1',
                'imageExten'       => 'jpg',
            ],
            ['title'      => 'Советы и полезности',
            'name' => 'advice',
                'description' => 'Полезные советы и лайфхаки для тех, кто любит самостоятельные путешествия или отправляется в путешествие впервые…',
                'slug'        => 'sovety-i-poleznosti',
                 'imageName'       => 'sova',
                'imageExten'       => 'jpg',
            ],
            ['title'      => 'Я и мои книги',
            'name' => 'mybook',
                'description' => 'Пишу, редактирую, путешествую, фотографирую, живу…',
                'slug'        => 'ya-i-moi-knigi',
                 'imageName'       => 'book_first',
                'imageExten'       => 'jpg',
            ],
        ]);
      
    }
}
