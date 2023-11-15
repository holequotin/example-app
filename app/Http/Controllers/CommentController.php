<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use Exception;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    protected $commentRepository;
    public function __construct(CommentRepositoryInterface $commentRepository) {
        $this->commentRepository = $commentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $comments = $this->commentRepository->getAll();
        return CommentResource::collection($comments);
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
    public function store(StoreCommentRequest $request)
    {
        //
        $validated = $request->validated();
        if(array_key_exists('image',$validated)) {
            $image = $validated['image'];
            $relativeUrl = $image->store('comments','public');
            $validated['imgPath'] = url('storage/'.$relativeUrl);
        }
        $comment = $this->commentRepository->create($validated);
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
        if($comment) {
            return new CommentResource($comment);
        }else{
            return response()->json([
                "error" => "Comment not found"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
        $validated = $request->validated();
        if(array_key_exists('image',$validated)) {
            $image = $validated['image'];
            $currRelativeUrl = str_replace(url('/'),'',$comment->imgPath);
            Storage::delete($currRelativeUrl);
            if($image) {
                $relativeUrl = $image->store('posts');
                $validated['imgPath'] = url($relativeUrl);
            }else{
                $validated['imgPath'] = null;
            }
        }
        $comment = $this->commentRepository->update($comment->id,$validated);
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deleted = $this->commentRepository->delete($id);
        if (!$deleted) {
            return response()->json(["message" => "Comment not found"], 404);
        }
        try {
            return response()->json(["message" => "Delete comment sucessfully"]);
        } catch (Exception $e) {
            return response()->json(["message" => "Comment not found"], 404);
        }
    }
}
