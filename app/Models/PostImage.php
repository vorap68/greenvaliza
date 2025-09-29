<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path_original',
        'path_large',
        'path_medium',
        'path_thumb',
        'order',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getOriginalUrlAttribute()
    {
        return asset('storage/' . $this->path_original);
    }

    public function getLargeUrlAttribute()
    {
        return asset('storage/' . $this->path_large);
    }

    public function getMediumUrlAttribute()
    {
        return asset('storage/' . $this->path_medium);
    }
    
    public function getThumbUrlAttribute()
    {
        return asset('storage/' . $this->path_thumb);
    }

}
