<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\FriendshipRepositoryInterface;
use App\Models\Friendship;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFriendshipRequest;
use App\Http\Requests\UpdateFriendshipRequest;
use App\Http\Resources\FriendshipResource;
use Exception;

class FriendshipController extends Controller
{   
    protected $friendshipRepository;
    public function __construct(FriendshipRepositoryInterface $friendshipRepository) {
        $this->friendshipRepository = $friendshipRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function getFriendsByUserId(string $userId)
    {
        //
        $friendships = $this->friendshipRepository->getFriendsByUserId($userId);
        return FriendshipResource::collection($friendships);
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
    public function store(StoreFriendshipRequest $request)
    {
        //
        $validated = $request->validated();
        $friendship = $this->friendshipRepository->create($validated);
        return new FriendshipResource($friendship);
    }

    /**
     * Display the specified resource.
     */
    public function show(string  $id)
    { 
        $friendship = $this->friendshipRepository->find($id);
        if($friendship) {
            return new FriendshipResource($friendship);
        }
        return response()->json([
            "error" => "Friendship not found"
        ],404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friendship $friendship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFriendshipRequest $request, string $id)
    {
        //
        $validated = $request->validated();
        $friendship = $this->friendshipRepository->update($id,$validated);
        if($friendship) {
            return new FriendshipResource($friendship);
        }
        return response()->json([
            'error' => 'Friendship not found'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deleted = $this->friendshipRepository->delete($id);
        if (!$deleted) {
            return response()->json(["message" => "Friendship not found"], 404);
        }
        try {
            return response()->json(["message" => "Delete friendship sucessfully"]);
        } catch (Exception $e) {
            return response()->json(["message" => "Friendship not found"], 404);
        }
    }
}
