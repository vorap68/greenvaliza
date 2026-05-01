<?php

namespace App\Models\Categories;


use App\Models\Posts\GuidePost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuideMenu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'guide_menu';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
         'is_visual',
    ];  


    /**
     * Get the guide post associated with the guide menu.
     */
    public function guidePost()
    {
        return $this->hasOne(GuidePost::class);
    }
}
