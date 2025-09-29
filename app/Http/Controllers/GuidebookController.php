<?php

namespace App\Http\Controllers;

use App\Models\Guidebook;
use Illuminate\Http\Request;

class GuidebookController extends Controller
{
    public function index(){
        
       $guidebooks =  Guidebook::all();
       //dd($guidebooks);
        return view('guidebooks.menu',compact('guidebooks'));
    }
}
