<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guidebook extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
    ];  

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
