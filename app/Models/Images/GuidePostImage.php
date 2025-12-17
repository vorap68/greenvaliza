<?php

namespace App\Models\Images;

use App\Models\Posts\GuidePost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidePostImage extends Model
{
    use HasFactory;
       protected $fillable = [
        'url',
        'alt_text',
        'filename',
        'travel_post_id',
    ];

    public function guidePost()
    {
        return $this->belongsTo(GuidePost::class);
    }
}
