<?php

namespace App\Http\Controllers\Web;

use App\Models\Advice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdviceController extends Controller
{
    public function index()
{
    $advices = Advice::all();
    //dd($advices);
    return view('advices.menu', compact('advices'));
}
}
