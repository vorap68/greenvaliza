<?php

namespace App\Http\Controllers\Web;

use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TravelController extends Controller
{
     public function index(){
        
       $travels =  Travel::all();
       //dd($travels);
        return view('travels.menu',compact('travels'));
    }
}
