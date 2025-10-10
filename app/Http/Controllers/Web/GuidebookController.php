<?php

namespace App\Http\Controllers\Web;

use App\Models\Guidebook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuidebookController extends Controller
{
    public function index(){
        
       $guidebooks =  Guidebook::all();
       //dd($guidebooks);
        return view('guidebooks.menu',compact('guidebooks'));
    }
}
