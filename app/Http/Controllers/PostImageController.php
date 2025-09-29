<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // 



class PostImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke( string $dir, string $method ='resize', string $size, string $filename )
    {
        //dd($dir, $method, $size, $filename);
        abort_if( !in_array($size, config('imagesize.allow_size')), 403 , 'Size not allowed');
        $storage = Storage::disk('images');
        // dd($storage);
        [$w,$h] = explode('x',$size);

        $manager = new ImageManager(new Driver());   
        $image = $manager->read(storage_path('app/public/images/riga39.jpg')); 
        //dd($image);  
        // ресайзим
$image->resize($w, $h);

// сохраняем
$image->save(storage_path("app/public/images/riga39_$size.jpg"));


    }   
  

  
}
