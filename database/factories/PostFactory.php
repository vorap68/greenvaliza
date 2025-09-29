<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          $category_id = Category::inRandomOrder()->first()->id;
            $title = $this->faker->sentence;
             $slug = Str::slug($title);
            $path = storage_path().'/app/public/images/posts/'.$slug;
              mkdir($path, 0777, true);
        return [
            'title' => $title,
            'description' => $this->faker->text(50),
            'content' => $this->faker->paragraph,
            'is_published' => $this->faker->boolean,
            'is_visual' => $this->faker->boolean,
            'category_id' => $category_id,
            'slug' =>$slug ,    
        ];
      
    }
}
