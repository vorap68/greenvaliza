<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MybookPost extends Model
{
    use HasFactory;
     protected $table = 'mybook_posts';

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
