<?php

namespace App\Http\Controllers;

use App\Models\MyBooks;
use Illuminate\Http\Request;

class MyBooksController extends Controller
{
    public function index()
    {
        $myBooks = MyBooks::all();
        //dd($myBooks);
        return view('mybooks.menu', compact('myBooks'));
    }
}
