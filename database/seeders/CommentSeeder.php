<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Метод вызывается для создания 10-ти комментариев для 10-ти случ польз
     * Для случ выбраной категории
     */
    public function run(): void
    {
        $commentables = [
            'AdvicePost' => 'App\Models\Posts\AdvicePost',
            'TravelPost' => 'App\Models\Posts\TravelPost',
            'GuidePost' => 'App\Models\Posts\GuidePost',
            'MybookPost' => 'App\Models\Posts\MybookPost',
        ];

        for ($i = 1; $i < 10; $i++) {
            $user= User::inRandomOrder()->first();
            dump('user_id', $user->id);
           $user_name = [$user->name,'гость'];
           $author_name_id = array_rand($user_name);
           $author_name = $user_name[$author_name_id];
           $user_id=($author_name ==='гость') ? null : $user->id;
           dump('user_name:',$author_name);
            $nameModel = array_rand($commentables);
            $commentable_type = $commentables[$nameModel];
            dump('nameModel', $nameModel);
            dump('commentable_type', $commentable_type);
            $commentable_id = $commentable_type::inRandomOrder()->first()->id;
            dump('commentable_id:', $commentable_id);
            $comment = Comment::create([
                'user_id' => $user_id,
                'commentable_type' => $commentable_type,
                'commentable_id' => $commentable_id,
                'content' => 'комментарии от:' . $user->id . ' к посту:' . $commentable_id . ' категории:' . $commentable_type,
                'admin_reply' => fake()->sentence(10),
                'author_name' => $author_name,
            ]);
           dump('comment', $comment);
        }
        //$this->childCreate();
    }

  
}
