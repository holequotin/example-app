<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Database\Factories\PostFactory;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;
    /**
     * Display a listing of post.
     * Return all post when userId param is null
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function index()
    {
        //
        $userId = request('userId');
        if (!$userId) {
            $posts = $this->postRepository->getAll();
        } else {
            $posts = $this->postRepository->getPostsByUser($userId);
        }
        return PostResource::collection($posts);
    }
    /**
     * Create fake data by using factory.
     */
    public function create(Request $request,string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "error" => "User not found"
            ], 404);
        } else {
            $posts = Post::factory()
                        ->count(10)
                        ->for($user)
                        ->create();
            return PostResource::collection($posts);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
        $validated = $request->validated();
        $post = $this->postRepository->create($validated);
        // $user = User::find($userId);
        // $post = new Post();
        // $post->content = $content;
        // $user->posts()->save($post);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = $this->postRepository->find($id);
        if (!$post) {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        } else {
            return new PostResource($post);
        }
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
    public function update(Request $request, Post $post)
    {
        //
        $content = $request['content'];
        $post->content = $content;
        $post->save();
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $post = $this->postRepository->delete($id);
        if (!$post) {
            return response()->json(["message" => "Post not found"], 404);
        }
        try {
            return response()->json(["message" => "Delete post sucessfully"]);
        } catch (Exception $e) {
            return response()->json(["message" => "Post not found"], 404);
        }
    }
}
