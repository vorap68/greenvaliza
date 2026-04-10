<?php
namespace App\Components;

class CreateNewPost
{
    protected $post_id;

    public function createCurrent(string $modelClass, string $slug, array $data = [])
    {
        $newPost = $modelClass::firstOrCreate(
            ['slug' => $slug],
            array_merge(['slug' => $slug], $data)
        );
       return $newPost;
    }
}
