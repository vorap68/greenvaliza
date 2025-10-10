<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 Route::get('/categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);
 Route::get('/guidebooks', [App\Http\Controllers\Api\GuidebookController::class, 'index']);
 Route::get('/travels', [App\Http\Controllers\Api\TravelController::class, 'index']);
  Route::get('/advices', [App\Http\Controllers\Api\AdviceController::class, 'index']);
  Route::get('/mybooks', [App\Http\Controllers\Api\MyBookController::class, 'index']);