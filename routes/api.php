<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Categories\CategoryMenu;

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

// Front роуты
Route::get('/guide', [App\Http\Controllers\Api\GuideController::class, 'index']);
Route::get('/guide/{slug}', [App\Http\Controllers\Api\GuideController::class, 'show'])->name('api.guides.show');

Route::get('/travel', [App\Http\Controllers\Api\TravelController::class, 'index'])->name('api.travel.index');
Route::get('/travel/post/{slug}', [App\Http\Controllers\Api\TravelController::class, 'postShow'])->name('api.travel.postshow');
Route::get('/travel/table/{slug}', [App\Http\Controllers\Api\TravelController::class, 'tableShow'])->name('api.travel.tableshow');

Route::get('/advice', [App\Http\Controllers\Api\AdviceController::class, 'index']);
Route::get('/advice/{slug}', [App\Http\Controllers\Api\AdviceController::class, 'show'])->name('api.advice.show');

Route::get('/mybook', [App\Http\Controllers\Api\MyBookController::class, 'index']);
Route::get('/mybook/{slug}', [App\Http\Controllers\Api\MyBookController::class, 'show'])->name('api.mybook.show');

//
// Admin routes!!!!!!!!!!! 
Route::prefix('admin')->group(function () {
    // Main page
    Route::get('/header/count', [App\Http\Controllers\Admin\HeaderController::class, 'countall']);
   
   //Adding pages 
    Route::post('/create-post-single', [App\Http\Controllers\Admin\Adding\PostSingleCreatorController::class, 'createPost'])->name('api.create.post');
    Route::post('/create-post-for-table', [App\Http\Controllers\Admin\Adding\PostForTableCreatorController::class, 'createPost'])->name('api.create.post.for.table');
    Route::post('/create-table', [App\Http\Controllers\Admin\Adding\TableCreatorController::class, 'createTable'])->name('api.create.table');
    Route::post('/create-image/{category_name}/{id}', [App\Http\Controllers\Admin\Adding\ImageCreatorController::class, 'createImage'])->name('api.create.image');
    Route::post('/create-image/nopost', [App\Http\Controllers\Admin\Adding\ImageCreatorController::class, 'createImageNoPost'])->name('api.create.image.nopost');

    //смена имени поста
    Route::put('/change-title/{category_name}/{id}', [App\Http\Controllers\Admin\ChangeTitle\TitleAllCategoryController::class, 'updateAllCat'])->name('api.titleall.update');
   Route::put('/change-title-travel/table/{id}', [App\Http\Controllers\Admin\ChangeTitle\TitleTravelController::class, 'updateTravelTable']);
   Route::put('/change-title-travel/post/single/{id}', [App\Http\Controllers\Admin\ChangeTitle\TitleTravelController::class, 'updateTravelPostSingle'])->name('api.titletravel.post');
   Route::put('/change-title-travel/post/final/{id}', [App\Http\Controllers\Admin\ChangeTitle\TitleTravelController::class, 'updateTravelPostFinal'])->name('api.titletravel.post');
   
    // роуты для карточек
    Route::get('/postcard-menu/{category_name}', [App\Http\Controllers\Admin\PostCardController::class, 'index']);
    Route::get('/postcard/{category_name}/{id}', [App\Http\Controllers\Admin\PostCardController::class, 'show'])->name('api.postcard.show');
    Route::post('/postcard/update/{category_name}/{id}', [App\Http\Controllers\Admin\PostCardController::class, 'update'])->name('api.postcard.update');
    Route::patch('/postcard/{category_name}/{id}/toggle-visual', [App\Http\Controllers\Admin\PostCardController::class, 'visual'])->name('api.postcard.visual');
    
    

    // роуты для гайдов
    Route::get('/guide', [App\Http\Controllers\Admin\GuideController::class, 'index']);
    Route::get('/guide/{slug}', [App\Http\Controllers\Admin\GuideController::class, 'show'])->name('api.guide.show');
    Route::put('/guide/{id}', [App\Http\Controllers\Admin\GuideController::class, 'update'])->name('api.guide.update');
    Route::patch('/guide/{id}/toggle-visual', [App\Http\Controllers\Admin\GuideController::class, 'visual'])->name('api.guide.visual');
    Route::get('/guide-images/{id}', [App\Http\Controllers\Admin\GuideController::class, 'getImages'])->name('api.guides.getImages');

    // роуты для тревел постов и травел таблиц
    Route::get('/travel-post', [App\Http\Controllers\Admin\TravelPostController::class, 'index'])->name('api.travels.index');
   Route::get('/travel-post/{id}', [App\Http\Controllers\Admin\TravelPostController::class, 'postShow'])->name('api.travels.postshow');
   Route::put('/travel-post/{id}', [App\Http\Controllers\Admin\TravelPostController::class, 'update'])->name('api.travels.update');
    Route::patch('/travel-post/{id}/toggle-visual', [App\Http\Controllers\Admin\TravelPostController::class, 'visual'])->name('api.travels.visual');
    Route::get('/travel-post-images/{id}', [App\Http\Controllers\Admin\TravelPostController::class, 'getImages'])->name('api.travels.getImages');
    
    Route::get('/travel-table', [App\Http\Controllers\Admin\TravelTableController::class, 'index'])->name('api.travels.index');
    Route::get('/travel-table/{id}', [App\Http\Controllers\Admin\TravelTableController::class, 'tableShow'])->name('api.travels.tableshow');
    Route::put('/travel-table/{id}', [App\Http\Controllers\Admin\TravelTableController::class, 'update'])->name('api.travels.update');
    Route::patch('/travel-table/{id}/toggle-visual', [App\Http\Controllers\Admin\TravelTableController::class, 'visual'])->name('api.travels.visual');
       Route::get('/travel-table-images/{id}', [App\Http\Controllers\Admin\TravelTableController::class, 'getImages'])->name('api.travels.getImages');
 

    //роуты для советов 
    Route::get('/advice', [App\Http\Controllers\Admin\AdviceController::class, 'index']);
    Route::get('/advice/{id}', [App\Http\Controllers\Admin\AdviceController::class, 'show'])->name('api.advices.show');
    Route::put('/advice/{id}', [App\Http\Controllers\Admin\AdviceController::class, 'update'])->name('api.advices.update');
    Route::patch('/advice/{id}/toggle-visual', [App\Http\Controllers\Admin\AdviceController::class, 'visual'])->name('api.advices.visual');
    Route::get('/advice-images/{id}', [App\Http\Controllers\Admin\AdviceController::class, 'getImages'])->name('api.advices.getImages');

    // роуты для моих книг
    Route::get('/mybook', [App\Http\Controllers\Admin\MyBookController::class, 'index']);
    Route::get('/mybook/{slug}', [App\Http\Controllers\Admin\MyBookController::class, 'show'])->name('api.mybook.show');
    Route::put('/mybook/{id}', [App\Http\Controllers\Admin\MyBookController::class, 'update'])->name('api.mybook.update');
    Route::patch('/mybook/{id}/toggle-visual', [App\Http\Controllers\Admin\MyBookController::class, 'visual'])->name('api.mybook.visual');
    Route::get('/mybook-images/{id}', [App\Http\Controllers\Admin\MyBookController::class, 'getImages'])->name('api.mybook.getImages');

//роуты для фото
    Route::get('/images/{category}', [App\Http\Controllers\Admin\Images\ImagesController::class, 'categoryImages'])->name('api.images.category');
    Route::get('/images/card/{categoryCard}', [App\Http\Controllers\Admin\Images\ImagesController::class, 'CardMenuImages'])->name('api.images.category.card');
   Route::get('/images/{category}/{id}', [App\Http\Controllers\Admin\Images\ImagesController::class, 'postCategoryImages'])->name('api.post.images.category');
   Route::post('/images/search', [App\Http\Controllers\Admin\Images\ImagesController::class, 'imageSearch'])->name('api.post.images.search');
  

});

