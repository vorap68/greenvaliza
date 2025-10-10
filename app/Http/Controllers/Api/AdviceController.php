<?php

namespace App\Http\Controllers\Api;

use App\Models\Advice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdviceResource;

class AdviceController extends Controller
{
    public function index()
{
    $advices = Advice::all();
  return AdviceResource::collection($advices);
}
}
