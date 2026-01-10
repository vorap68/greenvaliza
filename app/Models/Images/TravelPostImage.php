<?php

namespace App\Models\Images;

use App\Models\Posts\TravelPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelPostImage extends Model
{
    use HasFactory;
    protected $table = 'travel_post_images';

    protected $fillable = [
        'url',
        'alt_text',
        'filename',
        'travel_post_id',
    ];

    public function travelPost()
    {
        return $this->belongsTo(TravelPost::class);
    }
}
