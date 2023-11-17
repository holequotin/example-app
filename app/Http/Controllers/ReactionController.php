<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ReactionRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteReactionRequest;
use App\Http\Requests\StoreReactionRequest;
use App\Http\Resources\ReactionResource;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    protected $reactionRepository;
    public function __construct(ReactionRepositoryInterface $reactionRepository)
    {
        $this->reactionRepository = $reactionRepository;
    }
    //
    public function store(StoreReactionRequest $request)
    {
        $validated = $request->validated();
        $reaction = $this->reactionRepository->create($validated);
        return new ReactionResource($reaction);
    }

    public function getReactionByPost(Request $request,string $postId)
    {
        $reactions = $this->reactionRepository->getReactionByPost($postId);
        return ReactionResource::collection($reactions);
    }

    public function update(StoreReactionRequest $request)
    {
        $validated = $request->validated();
        $reaction = $this->reactionRepository->getReaction($validated['user_id'], $validated['post_id']);
        if ($reaction) {
            $reaction = $this->reactionRepository->update($reaction->id, $validated);
            return new ReactionResource($reaction);
        }
        return response()->json([
            'error' => 'Reaction not found',
        ], 404);
    }

    public function delete(DeleteReactionRequest $request)
    {
        $validated = $request->validated();
        $reaction = $this->reactionRepository->getReaction($validated['user_id'], $validated['post_id']);
        if ($reaction) {
            $deleted = $this->reactionRepository->delete($reaction->id);
            if ($deleted) {
                return response()->json([
                    "message" => "Delete reaction successfuly"
                ]);
            } else {
                return response()->json([
                    "error" => "Can not delete reaction"
                ],404);
            }
        } else {
            return response()->json([
                "error" => "Reaction not found"
            ],404);
        }
    }
}