<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;
    protected $tables = 'comments';
     
   protected $fillable = [
    'user_id',
    'commentable_type',
    'commentable_id',
    'author_name',
    'content',
    'status',
    'author_reply'
];


    
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
