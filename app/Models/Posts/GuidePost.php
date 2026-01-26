<?php

namespace App\Models\Posts;

use App\Models\Categories\GuideMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidePost extends Model
{
    use HasFactory;
       protected $fillable = [
         'title',
        'content',
        'is_visual',
        'description',
        'slug',
         'menu_id',
         ]; 

         public function guideMenu()
         {
             return $this->belongsTo(GuideMenu::class, 'menu_id');
         }
}