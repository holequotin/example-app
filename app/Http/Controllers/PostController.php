<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $content = $request['content'];
        $userId = $request['userId'];
        $user = User::find($userId);
        $post = new Post();
        $post->content = $content;
        $user->posts()->save($post);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                "message" => "Post not found"
            ],404);
        }else{
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
    public function destroy(Request $request,string $id)
    {   
        $post = Post::find($id);
        if(!$post) {
            return response()->json(["message" => "Post not found"],404);
        }
        try {
            $post->delete();
            return response()->json(["message" => "Delete post sucessfully"]);
        } catch (Exception $e) {
            return response()->json(["message" => "Post not found"],404);
        }
    }
}
