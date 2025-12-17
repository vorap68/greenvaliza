<?php

use App\Models\MyBook;
use App\Models\Category;
use App\Models\Posts\MybookPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories\AdviceMenu;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\AdviceResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\Web\MyBookController;
use App\Http\Controllers\Web\TravelController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\GuidebookController;
use App\Http\Controllers\Admin\TravelPostController;

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

Route::get('/testid', function () {
     $advices = AdviceMenu::all();
     $ttt = AdviceResource::collection($advices);
      dd($ttt);
});


// Auth::routes();

// старые роуты для админки на контроллерах laravel
// Route::get('admin', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
// Route::get('admin/travelpost/sorter/{field}',[TravelPostController::class,'sorter'])->name('admin.travelpost.sorter');
// Route::resource('admin/travelpost',TravelPostController::class);

Route::get('test', function () {
    dump('app_path:',app_path());
    dump('base_path:',base_path());
    dump('public_path:',public_path());
    dump('storage_path:',storage_path());
    dump('APP_URL:',env('APP_URL'));

  })->name('test');
//  Route::resource('category', CategoryController::class);
// Route::resource('post', PostController::class);
// Route::resource('postImage', PostImageController::class);



// Роут для загрузки фото в разных размерах

// Route::get('/images/{dir}/{method}/{size}/{filename}', PostImageController::class, )
//     ->where('method','resize|crop|fit')
//     ->where('size','\d+x\d+')
//      ->where('filename','.+\.(png|jpg|jpeg|bmp|gif)')
//     ->name('image.stored');

Route::get('{any?}', fn() => view('app'))->where('any', '^(?!admin).*$');
Route::get('admin/{any?}', fn() => view('admin'))->where('any', '.*');