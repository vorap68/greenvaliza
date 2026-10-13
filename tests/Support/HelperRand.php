<?php
namespace   Tests\Support;

class HelperRand
{
    public static function randonCategory(){
    $categories = $this->get('api/categories');
        $all_cat_name = [];
        $all_posts = [];
        foreach ($categories->json('data') as $item) {
            if ($item['name'] != 'travel') continue;
            $all_cat_name[] = $item['name'];
        };
        $cat_rand = array_rand($all_cat_name);
        $cat_name = $all_cat_name[$cat_rand];
    }
}