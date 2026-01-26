<?php

namespace App\Models\Categories;


use App\Models\Posts\GuidePost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuideMenu extends Model
{
    use HasFactory;

    protected $table = 'guide_menu';

    
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
         'is_visual',
    ];  

    public function guidePost()
    {
        return $this->hasOne(GuidePost::class);
    }
}
