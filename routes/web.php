<?php

use App\Models\MyBooks;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\MyBooksController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GuidebookController;
use App\Http\Controllers\PostImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/',function(){
    return view('app');
});



Auth::routes();

Route::get('/admin', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');

Route::get('test', function () {
   dd( asset('fonts/Montserrat-Regular.woff2'));
    dd(storage_path().'/app/public/images/categories');
        $category_id = Category::inRandomOrder()->first()->id;
        dd($category_id); 
})->name('test');
 Route::resource('category', CategoryController::class);
Route::resource('post', PostController::class);
Route::resource('postImage', PostImageController::class);

//Путеводители
Route::get('/nashi-puteshestviya', [TravelController::class, 'index'])->name('nashi-puteshestviya');
Route::get('/sovety-i-poleznosti', [AdviceController::class, 'index'])->name('sovety-i-poleznosti');
Route::get('/ya-i-moi-knigi', [MyBooksController::class, 'index'])->name('ya-i-moi-knigi');
Route::get('/putevoditeli', [GuidebookController::class, 'index'])->name('putevoditeli');
Route::get('/putevoditeli/{slug}', [GuidebookController::class, 'single'])->name('putevoditel.item');

// Роут для загрузки фото в разных размерах

Route::get('/images/{dir}/{method}/{size}/{filename}', PostImageController::class, )
    ->where('method','resize|crop|fit')
    ->where('size','\d+x\d+')
     ->where('filename','.+\.(png|jpg|jpeg|bmp|gif)')
    ->name('image.stored');

Route::get('{any?}', fn() => view('app'))->where('any', '^(?!api).*$');