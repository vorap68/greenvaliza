<?php

use App\Models\Posts\TravelPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

// старые роуты для админки на контроллерах laravel
// Route::get('admin', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
// Route::get('admin/travelpost/sorter/{field}',[TravelPostController::class,'sorter'])->name('admin.travelpost.sorter');
// Route::resource('admin/travelpost',TravelPostController::class);

Route::get('test', function () {
  dump('app_path:', app_path());
  dump('base_path:', base_path());
  dump('public_path:', public_path());
  dump('storage_path:', storage_path());
  dump('APP_URL:', env('APP_URL'));
  $single_posts = TravelPost::where('menu_id', '!=', null)->get();
  dd(count($single_posts));
})->name('test');

//!!!!!!!!!!!!!!!!!!!!!!
Route::get('/test-auth', function (Request $request) {
    return response()->json([
        'auth' => auth()->check(),
        'user' => auth()->user(),
        'session' => session()->getId(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'cookies' => $request->cookies->all(),
    ]);
});
//!!!!!!!!!!!!!!!!!!!!!!

Route::post('/login',[App\Http\Controllers\LoginController::class,'login']);
Route::post('/logout',[App\Http\Controllers\LoginController::class,'logout']);
Route::post('/register',[App\Http\Controllers\RegisterController::class,'register']);


Route::get('{any?}', fn() => view('app'))->where('any', '^(?!admin).*$');
Route::get('admin/{any?}', fn() => view('admin'))->where('any', '.*');
