<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $postType, string $slug, CommentService $comment)
    {
       $model = $comment->getModelClass($postType);
     $post = $model::where('slug', $slug)->firstOrFail();
        //return response()->json(['model'=>$model,'comments'=>$post->id]);
        $commitResult = $comment->getComments($model, $post->id);
        return response()->json(['comments' => $commitResult]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(string $postType, string $postId, CommentService $comment, StoreCommentRequest $request)
    { 
        $data = $request->validated();
                   //return response()->json(['postId'=>$comment,'postType'=>$postType]);
                   //return response()->json(['data'=>$data]);
        $commentOne = $comment->storeComment($postType, $data);
        return response()->json([
            'comment' => $commentOne
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     public function changeStatus(string $commentId,Request $request,  CommentService $comment)
    {
    
         //return response()->json(['oldStatus'=> $result,'id'=> $commentId]);
        $result = $comment->changeStatusComment($commentId);
        return response()->json(['change'=>$result]);
    } 
}
