<?php

namespace App\Models\Posts;

use App\Models\Categories\GuideMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidePost extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
         */
     protected $table = 'guide_posts';
    
       protected $fillable = [
         'title',
        'content',
        'is_visual',
        'description',
        'slug',
         'menu_id',
         ]; 


         /**
          * Get the guide menu associated with the guide post.
          */
         public function guideMenu()
         {
             return $this->belongsTo(GuideMenu::class, 'menu_id');
         }
}