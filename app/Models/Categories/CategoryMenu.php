<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMenu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'imageName',
        'imageExten',
        'slug',
        'description',
    ];
    
    /**
     * Get all categories.
     */
    public function index()
    {
        $categories_menu = CategoryMenu::all();
        return response()->json($categories_menu);
    }
        
}
