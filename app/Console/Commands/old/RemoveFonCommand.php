<?php

namespace App\Console\Commands;

use App\Models\Posts\TravelPost;
use App\Models\Posts\TravelTable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RemoveFonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
       protected $signature = 'remove:fon';

    protected $description = 'перенос фона поста из папки слага в папку с id';


    /**
     * Execute the console command.
     */
    public function handle()
    {
         $pathSlug = Storage::disk('public')->directories('images/travel/table');
      $folderNames = array_map('basename', $pathSlug);
        $folderNamesSlug = array_filter($folderNames, function ($name) {
            return !is_numeric($name);
        });
        $folderNamesNumber = array_filter($folderNames, function ($name) {
            return is_numeric($name);
        });


    dump($folderNamesSlug, $folderNamesNumber);

    $newAssocArray = [];// ассоц массив где ключ - id папки, значение - слаг папки
      foreach($folderNamesNumber as $folderNameNumber){
         $newAssocArray[$folderNameNumber] = TravelTable::where('id', $folderNameNumber)->value('slug');
      }

      dump($newAssocArray);
      foreach($newAssocArray as $id => $slug){
          $sourcePath = 'images/travel/table/' . $slug . '/firstfon.jpg';
          $destinationPath = 'images/travel/table/' . $id . '/firstfon.jpg';
          foreach($folderNamesSlug as $folderslug){
              if($folderslug === $slug){
                  if (Storage::disk('public')->exists($sourcePath)) {
                      Storage::disk('public')->move($sourcePath, $destinationPath);
                      $this->info("Moved fon.jpg from slug folder '$slug' to id folder '$id'.");
                  } else {
                      $this->warn("fon.jpg does not exist in slug folder '$slug'.");
                  }
              }
          }
         // die();
         
      }
    }
}
