<?php

use App\Models\Categories\CategoryMenu;
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

Route::get('/test', function () {
    $categories = CategoryMenu::all();
    dd($categories);

});

// роут на стартовую страницу
Route::get('/categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);

Route::get('/guide', [App\Http\Controllers\Api\GuideController::class, 'index']);
Route::get('/guide/{slug}', [App\Http\Controllers\Api\GuideController::class, 'show'])->name('api.guides.show');

Route::get('/travels', [App\Http\Controllers\Api\TravelController::class, 'index'])->name('api.travels.index');
Route::get('/travels/post/{slug}', [App\Http\Controllers\Admin\TravelPostController::class, 'postShow'])->name('api.travels.postshow');
Route::get('/travels/table/{slug}', [App\Http\Controllers\Admin\TravelTableController::class, 'tableShow'])->name('api.travels.tableshow');

Route::get('/advice', [App\Http\Controllers\Api\AdviceController::class, 'index']);
Route::get('/advice/{slug}', [App\Http\Controllers\Api\AdviceController::class, 'show'])->name('api.advice.show');

Route::get('/mybook', [App\Http\Controllers\Api\MyBookController::class, 'index']);
Route::get('/mybook/{slug}', [App\Http\Controllers\Api\MyBookController::class, 'show'])->name('api.mybook.show');

// Admin routes!!!!!!!!!!! 
Route::prefix('admin')->group(function () {
    // Main page
    Route::get('/header/count', [App\Http\Controllers\Admin\HeaderController::class, 'countall']);
   
   //Adding pages
    Route::post('/create-post', [App\Http\Controllers\Admin\Adding\PostCreatorController::class, 'createPost'])->name('api.create.post');
    Route::post('/create-table', [App\Http\Controllers\Admin\Adding\TableCreatorController::class, 'createTable'])->name('api.create.table');
    Route::post('/create-image', [App\Http\Controllers\Admin\Adding\ImageCreatorController::class, 'createImage'])->name('api.create.table');

    //смена имени поста
    Route::put('/change-title/{category_name}/{id}', [App\Http\Controllers\Admin\ChangeTitleController::class, 'update'])->name('api.titleupdate');
    // Route::put('/change-title/{category_name}/{id}', function($category_name, $id, Request $request) {
       
    //     return response()->json(['message' => 'Title update route works', 'category' => $category_name, 'id' => $id, 'new_title' => $request->input('title')]);
    // })->name('api.titleupdate');

    Route::get('/postcard-menu/{category_name}', [App\Http\Controllers\Admin\PostCardController::class, 'index']);
    Route::get('/postcard/{category_name}/{slug}', [App\Http\Controllers\Admin\PostCardController::class, 'show'])->name('api.postcard.show');
    Route::post('/postcard/update/{category_name}/{slug}', [App\Http\Controllers\Admin\PostCardController::class, 'update'])->name('api.postcard.update');
    Route::patch('/postcard/{category_name}/{id}/toggle-visual', [App\Http\Controllers\Admin\PostCardController::class, 'visual'])->name('api.postcard.visual');
    
    Route::get('/guide', [App\Http\Controllers\Admin\GuideController::class, 'index']);
    Route::get('/guide/{slug}', [App\Http\Controllers\Admin\GuideController::class, 'show'])->name('api.guide.show');
    Route::put('/guide/{id}', [App\Http\Controllers\Admin\GuideController::class, 'update'])->name('api.guide.update');
    Route::patch('/guide/{id}/toggle-visual', [App\Http\Controllers\Admin\GuideController::class, 'visual'])->name('api.guide.visual');
    Route::get('/guide-images/{post_id}', [App\Http\Controllers\Admin\GuideController::class, 'getImages'])->name('api.guides.getImages');

    Route::get('/travels-post', [App\Http\Controllers\Admin\TravelPostController::class, 'index'])->name('api.travels.index');
    Route::get('/travels-post/{slug}', [App\Http\Controllers\Admin\TravelPostController::class, 'postShow'])->name('api.travels.postshow');
    Route::put('/travels-post/{id}', [App\Http\Controllers\Admin\TravelPostController::class, 'update'])->name('api.travels.update');
    Route::patch('/travels-post/{id}/toggle-visual', [App\Http\Controllers\Admin\TravelPostController::class, 'visual'])->name('api.travels.visual');
    Route::get('/travels-post-images/{post_id}', [App\Http\Controllers\Admin\TravelPostController::class, 'getImages'])->name('api.travels.getImages');
    
    Route::get('/travels-table', [App\Http\Controllers\Admin\TravelTableController::class, 'index'])->name('api.travels.index');
    Route::get('/travels-table/{slug}', [App\Http\Controllers\Admin\TravelTableController::class, 'tableShow'])->name('api.travels.tableshow');
    Route::put('/travels-table/{id}', [App\Http\Controllers\Admin\TravelTableController::class, 'update'])->name('api.travels.update');
    Route::patch('/travels-table/{id}/toggle-visual', [App\Http\Controllers\Admin\TravelTableController::class, 'visual'])->name('api.travels.visual');
   
 

    Route::get('/advices', [App\Http\Controllers\Admin\AdviceController::class, 'index']);
    Route::get('/advices/{id}', [App\Http\Controllers\Admin\AdviceController::class, 'show'])->name('api.advices.show');
    Route::put('/advices/{id}', [App\Http\Controllers\Admin\AdviceController::class, 'update'])->name('api.advices.update');
    Route::patch('/advices/{id}/toggle-visual', [App\Http\Controllers\Admin\AdviceController::class, 'visual'])->name('api.advices.visual');
    Route::get('/advices-images/{post_id}', [App\Http\Controllers\Admin\AdviceController::class, 'getImages'])->name('api.advices.getImages');

    Route::get('/mybook', [App\Http\Controllers\Admin\MyBookController::class, 'index']);
    Route::get('/mybook/{slug}', [App\Http\Controllers\Admin\MyBookController::class, 'show'])->name('api.mybook.show');
    Route::put('/mybook/{id}', [App\Http\Controllers\Admin\MyBookController::class, 'update'])->name('api.mybook.update');
    Route::patch('/mybook/{id}/toggle-visual', [App\Http\Controllers\Admin\MyBookController::class, 'visual'])->name('api.mybook.visual');
    Route::get('/mybook-images/{post_id}', [App\Http\Controllers\Admin\MyBookController::class, 'getImages'])->name('api.mybook.getImages');

});

//  Route::get('/guide/{slug}',function($slug){ 
//      return response()->json([
//          'slug_from_route' => $slug,
//       ]);
//  });
