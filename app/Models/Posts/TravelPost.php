<?php
namespace App\Models\Posts;

use App\Models\Categories\TravelMenu;
use App\Models\Images\TravelPostImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPost extends Model
{
    use HasFactory;

    protected $table = 'travel_posts';

    protected $fillable = [
        'title',
        'content',
        'is_visual',
        'description',
        'slug',
        'travel_table_id',

    ];

    public function index()
    {
        return TravelPost::all();
    }

    public function travelTable()
    {
        return $this->belongsTo(TravelTable::class);
    }

    public function travelPostImages()
    {
        return $this->hasMany(TravelPostImage::class);
    }
}
