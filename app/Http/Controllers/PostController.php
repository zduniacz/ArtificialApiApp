<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\Transformers\PostTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->category_id = $request->category;
        $post->user()->associate($request->user());
        $post->save();
        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function index()
    {
        $posts = Post::sortable(['id' => 'desc'])->paginate(5);//Post::scopeLatestFirst()->get();
        $postsCollection = $posts->getCollection();
        return fractal()
        ->collection($postsCollection)
        ->parseIncludes(['user'])
        ->transformWith(new PostTransformer)
        ->paginateWith(new IlluminatePaginatorAdapter($posts))
        ->toArray();
    }

    public function single(Post $post)
    {
        return fractal()
            ->item($post)
            ->parseIncludes(['user', 'comments', 'comments.user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update (UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->title = $request->get('title', $post->title);
        $post->title = $request->get('body', $post->title);
        $post->title = $request->get('category', $post->title);
        $post->save();
        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        $post->delete();
        return response(null, 204);
    }
}
