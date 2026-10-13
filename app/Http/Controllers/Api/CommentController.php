<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
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
     //$post = $model::where('slug', $slug)->firstOrFail();
        //return response()->json(['model'=>$model,'comments'=>$post->id]);
        $commitResult = $comment->getCommentsFront($model, $postId);
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

   
}
