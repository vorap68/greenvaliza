<?php

namespace App\Models\Categories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyBookMenu extends Model
{
    use HasFactory;

    protected $table = 'mybook_menu';
      
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
        'is_visual',
    ];  

    // public function posts()
    // {
    //     return $this->hasMany(Post::class, 'category_id', 'id');
    // }

}
