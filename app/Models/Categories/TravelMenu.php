<?php

namespace App\Models\Categories;

use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelMenu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
     protected $table = 'travel_menu';

      /**
       * The attributes that are mass assignable.
         */
    protected $fillable = [
        'title',
       'imageName',
        'description',
        'slug',
        'type',
        'term_id',
         'is_visual',
      
    ];  

    /**
     * Get the travel post associated with the travel menu.
     */
    public function travelPost()
    {
        return $this->hasOne(TravelPost::class, 'menu_id', 'id');
    }

    public function travelTable()
    {
        return $this->hasOne(TravelTable::class,'menu_id','id');
    }

}
