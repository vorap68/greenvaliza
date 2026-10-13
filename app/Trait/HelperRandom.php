<?php
namespace App\Trait;

use App\Models\Categories\TravelMenu;

trait HelperRandom
{
     protected  function randomCategory(){
    $categories = $this->get('api/categories');
        $all_cat_name = [];
        $all_posts = [];
        foreach ($categories->json('data') as $item) {
             //if($item['name'] != 'travel') continue;
            $all_cat_name[] = $item['name'];
            };
        $cat_rand = array_rand($all_cat_name);
        $cat_name = $all_cat_name[$cat_rand];
        return $cat_name;
    }

    protected function randomTravelItem() 
    {
        $travel_item= TravelMenu::inRandomOrder()->first(['title','slug','type']); 
         dump('Выбрана карточка из меню', $travel_item['title']); 
         dump(' что это , таблица или пост', $travel_item['type']);
            echo "Нажмите Enter...";
            fgets(STDIN);
       return $travel_item;
    }
   }