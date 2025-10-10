<?php

namespace App\Http\Controllers\Web;

use App\Models\MyBooks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyBooksController extends Controller
{
    public function index()
    {
        $myBooks = MyBooks::all();
        //dd($myBooks);
        return view('mybooks.menu', compact('myBooks'));
    }
}
