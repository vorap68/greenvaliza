<?php

namespace App\Http\Controllers\Api;

use App\Models\Travel;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;

class TravelController extends Controller
{
     public function index(){
        
       $travels =  Travel::all();
      
        return TravelResource::collection($travels);
    }
}
