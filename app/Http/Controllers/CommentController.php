<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Http\Requests\StoreCommentRequest;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user()->associate($request->user());
        $comment->post()->associate($post);

        $post->comments()->save($comment);
        return fractal()
            ->item($comment)
            ->parseIncludes(['user'])
            ->transformWith(new CommentTransformer)
            ->toArray();
    }
}
