<?php

namespace App\Models\Categories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuideMenu extends Model
{
    use HasFactory;

    protected $table = 'guide_menu';

    
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
    ];  

    // public function posts()
    // {
    //     return $this->hasMany(Post::class, 'category_id', 'id');
    // }
}
