<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\CommentQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreCommentsRequest;
use App\Http\Requests\API\V1\UpdateCommentsRequest;
use App\Http\Resources\V1\CommentCollection;
use App\Http\Resources\V1\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * Note: Only usefull for admin?
     */
    public function index(Request $request): CommentCollection
    {
        $filter = new CommentQuery();
        $queryItems = $filter->transform($request);
        return new CommentCollection(Comment::where($queryItems)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentsRequest $request): CommentResource
    {
        return new CommentResource(Comment::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentsRequest $request, Comment $comment): CommentResource
    {
        $comment->update($request->all());
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}
