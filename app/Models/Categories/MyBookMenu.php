<?php

namespace App\Models\Categories;

use App\Models\Post;
use App\Models\Posts\MybookPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyBookMenu extends Model
{
    use HasFactory;

    protected $table = 'mybook_menu';
      
    protected $fillable = [
        'title',
        'imageName',
        'description',
        'slug',
        'is_visual',
    ];  

    public function mybookPost()
    {
        return $this->hasMany(MybookPost::class, );
     }

}
