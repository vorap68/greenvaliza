<?php

namespace App\Models\Posts;



use App\Models\Categories\TravelMenu;
use App\Models\Images\TravelPostImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelPost extends Model
{
    use HasFactory;

    protected $table = 'travel_posts';

    protected $fillable = [
        'title',
        'content',
        'is_published',
        'is_visual',
        'parent_id',
        'description',
        'slug',
          'travels_menu_id',
          'type'
        
    ];  

    public function index(){
        return TravelPost::all();
    }

 
   

    public function travelMenu()
    {
        return $this->belongsTo(TravelMenu::class, 'travels_menu_id', 'term_id');
    }

    public function travelPostImages()
    {
        return $this->hasMany(TravelPostImage::class);
    }   
}
