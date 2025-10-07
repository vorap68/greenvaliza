<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'travel_posts';

    protected $fillable = [
        'title',
        'content',
        'is_published',
        'is_visual',
        'travel_id',
        'description',
        'slug',
    ];  

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }   
}
