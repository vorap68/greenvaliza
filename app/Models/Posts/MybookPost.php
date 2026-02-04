<?php

namespace App\Models\Posts;

use App\Models\Categories\MyBookMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MybookPost extends Model
{
    use HasFactory;
     protected $table = 'mybook_posts';

      protected $fillable = [
         'title',
        'content',
        'is_visual',
        'description',
        'slug',
         'menu_id',
         
    ];  

    public function mybookMenu(){
       
            return $this->belongsTo(MyBookMenu::class, 'menu_id'); 
        
    }
}
