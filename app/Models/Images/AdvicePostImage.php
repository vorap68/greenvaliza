<?php

namespace App\Models\Images;

use App\Models\Posts\AdvicePost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvicePostImage extends Model
{
    use HasFactory;

      protected $fillable = [
        'url',
        'alt_text',
        'filename',
        'advice_post_id',
    ];

    public function advicePost()
    {
        return $this->belongsTo(AdvicePost::class);
    }
}
