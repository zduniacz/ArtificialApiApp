<?php

namespace App\Transformers;
use App\Comment;
class CommentTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Comment $comment) {
        return [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at->toDateTimeString(),
            'created_at_human' => $comment->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer);
    }
    
}