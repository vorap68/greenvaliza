<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $postType, string $postId, CommentService $comment)
    {
        $model = $comment->getModelClass($postType);
        //$post = $model::findOrFail($postId);
        //return response()->json(['model'=>$model,'comments'=>$post->id]);
        $commitResult = $comment->getCommentsAdmin($model, $postId);
        return response()->json(['comments' => $commitResult]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(string $commentId, Request $request, CommentService $comment)
    {
        $data = $request->validate([
            'text' => 'string|max:500',
        ]);
        $reply = $data['text'];
         $result = $comment->replyAdmin($commentId, $reply);
        return response()->json([
            'newReply' => $result
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function remove(string $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function changeStatus(string $commentId, Request $request,  CommentService $comment)
    {

        //return response()->json(['oldStatus'=> $result,'id'=> $commentId]);
        $result = $comment->changeStatusComment($commentId);
        return response()->json(['change' => $result]);
    }

    public function replyDelete(string $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->admin_reply = null;
        $comment->save();
        return response()->json([
            'success' => true
        ]);
    }
}
