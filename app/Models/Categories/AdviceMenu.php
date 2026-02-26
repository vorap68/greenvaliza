<?php

namespace App\Models\Categories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdviceMenu extends Model
{
    use HasFactory;
     protected $table = 'advice_menu';
     protected $fillable = [
        'title',
        'imageName',
        'description', 
        'slug',
        'is_visual',
    ];  

    public function advicePost()
    {
        return $this->hasOne(\App\Models\Posts\AdvicePost::class); 
    }

   
}
