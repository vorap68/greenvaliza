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

Route::get('/guide', [App\Http\Controllers\Api\GuideController::class, 'index']);
Route::get('/guide/{slug}', [App\Http\Controllers\Api\GuideController::class, 'show'])->name('api.guides.show');

Route::get('/travels', [App\Http\Controllers\Api\TravelController::class, 'index'])->name('api.travels.index');
Route::get('/travels/{slug}', [App\Http\Controllers\Api\TravelController::class, 'show'])->name('api.travels.show');


Route::get('/advice', [App\Http\Controllers\Api\AdviceController::class, 'index']);
Route::get('/advice/{slug}', [App\Http\Controllers\Api\AdviceController::class, 'show'])->name('api.advice.show');


Route::get('/mybook', [App\Http\Controllers\Api\MyBookController::class, 'index']);
Route::get('/mybook/{slug}', [App\Http\Controllers\Api\MyBookController::class,'show'])->name('api.mybook.show');

Route::prefix('admin')->group(function () {
    Route::get('/posts/count', [App\Http\Controllers\Admin\TravelController::class, 'postCount']);
    Route::get('/images/count', [App\Http\Controllers\Admin\TravelController::class, 'imagesCount']);
    Route::post('/create-post', [App\Http\Controllers\Admin\PostCreatorController::class, 'createPost'])->name('api.create.post');
    Route::post('/create-menu', [App\Http\Controllers\Admin\PostCreatorController::class, 'createMenu'])->name('api.create.menu');

    Route::get('/postcard-menu/{category_name}', [App\Http\Controllers\Admin\PostCardController::class, 'index']);
    Route::get('/postcard/{category_name}/{slug}', [App\Http\Controllers\Admin\PostCardController::class, 'show'])->name('api.postcard.show');
       // Route::put('/postcard/edit/{category_name}/{slug}', [App\Http\Controllers\Admin\PostCardController::class, 'show'])->name('api.postcard.show');
    Route::post('/postcard/update/{category_name}/{slug}', [App\Http\Controllers\Admin\PostCardController::class, 'update'])->name('api.postcard.update');

    // Route::get('/category-menu44/{category_title}',function($category_title){
    //     return response()->json([
    //         'category_title_from_route' => $category_title,
    //      ]) ;
    // });
   // Route::get('/guide/{slug}', [App\Http\Controllers\Admin\GuideController::class, 'show'])->name('api.guide.show');
   // Route::put('/guide/{id}', [App\Http\Controllers\Admin\GuideController::class, 'update'])->name('api.guide.update');
   // Route::get('/guide-images/{post_id}', [App\Http\Controllers\Admin\GuideController::class, 'getImages'])->name('api.guides.getImages');

    Route::get('/guide', [App\Http\Controllers\Admin\GuideController::class, 'index']);
    Route::get('/guide/{slug}', [App\Http\Controllers\Admin\GuideController::class, 'show'])->name('api.guide.show');
    Route::put('/guide/{id}', [App\Http\Controllers\Admin\GuideController::class, 'update'])->name('api.guide.update');
    Route::get('/guide-images/{post_id}', [App\Http\Controllers\Admin\GuideController::class, 'getImages'])->name('api.guides.getImages');

    Route::get('/travels', [App\Http\Controllers\Admin\TravelController::class, 'index'])->name('api.travels.index');
    Route::get('/travels-menu', [App\Http\Controllers\Admin\TravelController::class, 'getMenu'])->name('api.travels-menu.index');
    Route::get('/travels/{slug}', [App\Http\Controllers\Admin\TravelController::class, 'show'])->name('api.travels.show');
    Route::put('/travels/{id}', [App\Http\Controllers\Admin\TravelController::class, 'update'])->name('api.travels.update');
    Route::get('/travel-images/{post_id}', [App\Http\Controllers\Admin\TravelController::class, 'getImages'])->name('api.travels.getImages');

    Route::get('/advices', [App\Http\Controllers\Admin\AdviceController::class, 'index']);
    Route::get('/advices/{slug}', [App\Http\Controllers\Admin\AdviceController::class, 'show'])->name('api.advices.show');
    Route::put('/advices/{id}', [App\Http\Controllers\Admin\AdviceController::class, 'update'])->name('api.advices.update');
    Route::get('/advices-images/{post_id}', [App\Http\Controllers\Admin\AdviceController::class, 'getImages'])->name('api.advices.getImages');

    Route::get('/mybook', [App\Http\Controllers\Admin\MyBookController::class, 'index']);
    Route::get('/mybook/{slug}', [App\Http\Controllers\Admin\MyBookController::class, 'show'])->name('api.mybook.show');
    Route::put('/mybook/{id}', [App\Http\Controllers\Admin\MyBookController::class, 'update'])->name('api.mybook.update');
    Route::get('/mybook-images/{post_id}', [App\Http\Controllers\Admin\MyBookController::class, 'getImages'])->name('api.mybook.getImages');

});

//  Route::get('/guide/{slug}',function($slug){
//      return response()->json([
//          'slug_from_route' => $slug,
//       ]);
//  });
