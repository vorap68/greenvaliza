<?php

namespace App\Http\Controllers\Web;

use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuidebookController extends Controller
{
    public function index(){
        
       $guide =  Guide::all();
       //dd($guide);
        return view('guide.menu',compact('guide'));
    }
}
