<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::paginate(10);
        return PostResource::collection($posts);
    }

    public function show(int $id): PostResource
    {
        $post = Post::findOrFailCustom($id);
        return new PostResource($post);
    }

    public function store(PostRequest $request): PostResource
    {
        $post = Post::create($request->validated());
        return new PostResource($post);
    }

    public function update(PostRequest $request, int $id): PostResource
    {
        $post = Post::findOrFailCustom($id);
        $post->update($request->validated());
        return new PostResource($post);
    }

    public function destroy(int $id): JsonResponse
    {
        $post = Post::findOrFailCustom($id);
        $post->delete();
        return response()->json(null, 204);
    }
}
