<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Categories\Category;
use App\Models\Categories\CategoryMenu;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
       $categories = CategoryMenu::all();
      
       //return response()->json('categories',$categories);
    
       return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

   

  
}
