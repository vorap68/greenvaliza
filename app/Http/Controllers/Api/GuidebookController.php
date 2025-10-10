<?php

namespace App\Http\Controllers\Api;

use App\Models\Guidebook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuidebookResource;

class GuidebookController extends Controller

{
    public function index(){
        
       $guidebooks =  Guidebook::all();
       //dd($guidebooks);
        return GuidebookResource::collection($guidebooks);
    }
}
