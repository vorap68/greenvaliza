<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvicePost extends Model
{
    use HasFactory;
     protected $table = 'advice_posts';

    protected $fillable = [
        'title',
        'content',
        'is_published',
        'is_visual',
        'travel_id',
        'description',
        'slug',
    ];  
}
