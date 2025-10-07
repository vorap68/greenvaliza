<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyBooks extends Model
{
    use HasFactory;

    protected $table = 'my_books';
      
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'description',
        'slug',
    ];  

}
