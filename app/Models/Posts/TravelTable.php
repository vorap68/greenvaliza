<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelTable extends Model
{
    use HasFactory;

    protected $table = 'travel_table';
    protected $fillable = [
        'title',
        'description',
        'content',
        'slug',
        'term_id',
        'is_visual',
    ];

    public function travelPosts()
    {
        return $this->hasMany(TravelPost::class);
    }

}


