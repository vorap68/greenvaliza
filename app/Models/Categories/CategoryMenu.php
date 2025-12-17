<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMenu extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'slug',
        'description',
    ];
    
    public function index()
    {
        $categories_menu = CategoryMenu::all();
        return response()->json($categories_menu);
    }
        
}
