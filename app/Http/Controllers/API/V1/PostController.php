<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\CommentQuery;
use App\Filters\API\V1\PostQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\UpdatePostRequest;
use App\Http\Requests\API\V1\StorePostRequest;
use App\Http\Resources\V1\CommentCollection;
use App\Http\Resources\V1\CommentResource;
use App\Http\Resources\V1\PostCollection;
use App\Http\Resources\V1\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * Note: Only usefull for admin?
     */
    public function index(Request $request): PostCollection
    {
        $filter = new PostQuery();
        $queryItems = $filter->transform($request);
        return new PostCollection(Post::where($queryItems)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): PostResource
    {
        return new PostResource(Post::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post->update($request->all());
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.']);
    }

    public function comments(Request $request, Post $post): CommentCollection
    {
        $filter = new CommentQuery();
        $queryItems = $filter->transform($request);
        return new CommentCollection($post->comments()->where($queryItems)->get());
    }

    /**
     * Post a new message in a specific conversation with the logged in user as owner
     */
    public function addComment(Request $request, Post $post): CommentResource
    {
        $request->merge([
            'user_uuid' => auth()->id(),
            'post_uuid' => $post->uuid
        ]);

        $comment = Comment::create($request->all());
        return new CommentResource($comment);
    }
}
