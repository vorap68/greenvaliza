<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index()
{
    $advices = Advice::all();
    //dd($advices);
    return view('advices.menu', compact('advices'));
}
}
