<?php

namespace App\Models\Categories;

use App\Models\Posts\MybookPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyBookMenu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'mybook_menu';
      
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'imageName',
        'description',
        'slug',
        'is_visual',
    ];  

    /**
     * Get the mybook post associated with the mybook menu.
         */
    public function mybookPost()
    {
        return $this->hasOne(MybookPost::class, ); 
     }

}
