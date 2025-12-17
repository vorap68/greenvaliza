<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuidePost extends Model
{
    use HasFactory;
       protected $fillable = [
        'title',
        'content',
        'is_published',
        'is_visual',
       'description',
        'slug',
        'created_at',
         
    ];  

}
