<?php

namespace App\Models\Posts;

use App\Models\Categories\TravelMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelTable extends Model
{
    use HasFactory;

    protected $table = 'travel_table';
    protected $fillable = [
        'title',
        'content',
        'slug',
        'menu_id',
        'is_visual',
    ];

    public function travelPosts()
    {
        return $this->hasMany(TravelPost::class);
    }

    public function travelMenu(){
        return $this->belongsTo(TravelMenu::class,'menu_id','id');
    }

}


