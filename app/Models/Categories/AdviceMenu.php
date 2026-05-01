<?php

namespace App\Models\Categories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class AdviceMenu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
     protected $table = 'advice_menu';

     /**
      *  The attributes that are mass assignable.   
      */
     protected $fillable = [
        'title',
        'imageName',
        'description', 
        'slug',
        'is_visual',
    ];  

    /**
     * Get the advice post associated with the advice menu.     
     */
    public function advicePost()
    {
        return $this->hasOne(\App\Models\Posts\AdvicePost::class); 
    }

   
}
