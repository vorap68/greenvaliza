<?php
namespace App\Models\Posts;

use App\Models\Categories\TravelMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPost extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'travel_posts';

    protected $fillable = [
        'title',
        'content',
        'is_visual',
        'description',
        'slug',
        'table_id',
        'menu_id',
    ];

    /**
     * Get all travel posts.
     */
    public function index()
    {
        return TravelPost::all();
    }

    /**
     * Get the travel table associated with the travel post.
     */
    public function travelTable()
    {
        return $this->belongsTo(TravelTable::class, 'table_id');
    }
   
    /**
     * Get the travel menu associated with the travel post.
     */
    public function travelMenu()
    {
        return $this->belongsTo(TravelMenu::class, 'menu_id');
    }

  
}
