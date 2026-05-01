<?php

namespace App\Models\Posts;

use App\Models\Categories\TravelMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelTable extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'travel_table';


    protected $fillable = [
        'title',
        'content',
        'slug',
        'menu_id',
        'is_visual',
    ];

    /**
     * Get the travel posts associated with the travel table.
     */
    public function travelPosts()
    {
        return $this->hasMany(TravelPost::class, 'table_id', 'id');
    }

    /**
     * Get the travel menu associated with the travel table.
     */
    public function travelMenu()
    {
        return $this->belongsTo(TravelMenu::class, 'menu_id', 'id');
    }

}


