<?php

namespace App\Http\Controllers\Admin\Adding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TableCreatorController extends Controller
{
     public function tableCreate(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string'
        ]);
    }  
}
