<?php

namespace App\Models\Categories;

use App\Models\Post;
use App\Models\Posts\TravelPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelMenu extends Model
{
    use HasFactory;
     protected $table = 'travels_menu';

      
    protected $fillable = [
        'title',
       'imageName',
        'imageExten',
        'description',
        'slug',
        'type',
      
    ];  

    public function posts()
    {
        return $this->hasMany(TravelPost::class);
    }

}
