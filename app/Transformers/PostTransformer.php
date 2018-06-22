<?php

namespace App\Transformers;
use App\Post;
class PostTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user', 'comments'];

    public function transform(Post $post) {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'created_at' => $post->created_at->toDateTimeString(),
            'created_at_human' => $post->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeComments(Post $post)
    {
        return $this->collection($post->comments, new CommentTransformer);
    }
}