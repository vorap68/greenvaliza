<?php

namespace App\Services;

use  App\Models\Comment;
use App\Models\Posts\AdvicePost;
use App\Models\Posts\GuidePost;
use App\Models\Posts\MybookPost;
use App\Models\Posts\TravelPost;


class CommentService
{

    public function getModelClass(string $postType): String
    {
        return match ($postType) {
            'advice' => AdvicePost::class,
            'guide'  => GuidePost::class,
            'travel' => TravelPost::class,
            'mybook' => MybookPost::class,
            default => throw new \InvalidArgumentException(
                "Unknown post type: {$postType}"
            ),
        };
    }

    public function getCommentsFront(string $type, string $id)

    {
        $comments = Comment::where(['commentable_type' => $type, 'commentable_id' => $id,'status' => 1])->get();
                    return $comments;
    }

    public function getCommentsAdmin(string $type, string $id)

    {
        $comments = Comment::where(['commentable_type' => $type, 'commentable_id' => $id])->get();
                    return $comments;
    }


    public function storeComment($postType,array  $data)
    {
        if (auth()->check()) {
            // пользователь авторизован
            $userId = auth()->id();
        } else {
            // гость
            $userId = null;
        };
      
        $commentOne = Comment::create(
            [
                'user_id' => $userId,
                'commentable_type' => $data['commentable_type'],
                'commentable_id' => $data['commentable_id'],
                'author_name' => $data['author_name'],
                'content' => $data['content'],
            ]
        );
        return $commentOne;
    }

    /**
     * Метод изменения статуса комментария
     */
    public function changeStatusComment(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = (int) $comment->status === 1 ? 0 : 1;
        $comment->save();
         return $comment->status; 
        
    }

    /**
     * Метод сохран ответа админа
     */

    public function replyAdmin(string $id, string  $reply)
    {
       
        $comment = Comment::findOrFail($id);
        $comment->admin_reply =  $reply;
        $comment->save();
         return $comment->admin_reply; 
    }
}
