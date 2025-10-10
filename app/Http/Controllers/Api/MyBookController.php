<?php

namespace App\Http\Controllers\Api;

use App\Models\MyBooks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MyBookResource;

class MyBookController extends Controller
{
    public function index()
    {
        $myBooks = MyBooks::all();
     return MyBookResource::collection($myBooks);
    }
}
