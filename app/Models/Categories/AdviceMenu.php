<?php

namespace App\Models\Categories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdviceMenu extends Model
{
    use HasFactory;
     protected $table = 'advices_menu';
     protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
        'is_visual',
    ];  

   
}
