<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Categories\CategoryMenu;
/**
 * Controller for returning categories for the main page.
 */
class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
       $categories = CategoryMenu::all();
      return CategoryResource::collection($categories);
    }

   }
