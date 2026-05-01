<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для работы с изображениями
 */
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
