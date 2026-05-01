<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvicePost extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
         */
     protected $table = 'advice_posts';

    protected $fillable = [
       'title',
        'content',
        'is_visual',
        'description',
        'slug',
        'menu_id',
    ];  

    /**
     * Get the advice menu associated with the advice post.
     */
    public function adviceMenu()
    {
        return $this->belongsTo(\App\Models\Categories\AdviceMenu::class,'menu_id'); 
    }
}
