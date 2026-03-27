<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'post_id',
        'filename',
        'alt_text',
    ];
}
