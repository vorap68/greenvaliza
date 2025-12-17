<?php

namespace App\Http\Controllers\Web;

use App\Models\MyBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyBookController extends Controller
{
    public function index()
    {
        $MyBook = MyBook::all();
        //dd($MyBook);
        return view('MyBook.menu', compact('MyBook'));
    }
}
