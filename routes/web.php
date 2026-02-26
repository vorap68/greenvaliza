<?php


use App\Models\Posts\TravelTable;
use App\Models\Categories\AdviceMenu;
use App\Models\Categories\TravelMenu;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\AdviceResource;

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
// Route::get('/testtable/{slug}', function($slug){
//    $travel = TravelTable::where('slug', $slug)->firstOrFail();
//    dd($travel);

// });

// Auth::routes();

// измененные БД
Route::get('changeBD',function(){
$posts = TravelMenu::get(['id', 'slug', 'term_id']);
//dd($posts);
foreach($posts as $post){
    $tablePost = TravelTable::where('slug',$post->slug)->first();
    if($tablePost){
        $tablePost->term_id = $post->term_id;
        $tablePost->save();
       // die();
    }
}

});



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

Route::get('{any?}', fn() => view('app'))->where('any', '^(?!admin).*$');
Route::get('admin/{any?}', fn() => view('admin'))->where('any', '.*');