<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\FriendshipRepositoryInterface;
use App\Enums\FriendshipStatus;
use App\Models\Friendship;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFriendshipRequest;
use App\Http\Requests\UpdateFriendshipRequest;
use App\Http\Requests\UpdateFriendshipStatusRequest;
use App\Http\Resources\FriendshipResource;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{   
    protected $friendshipRepository;
    public function __construct(FriendshipRepositoryInterface $friendshipRepository) {
        $this->friendshipRepository = $friendshipRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function getFriends()
    {
        //
        $userId = auth()->user()->id;
        $friends = $this->friendshipRepository->getFriendsByUserId($userId);
        return UserResource::collection($friends);
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
        if(auth()->check()){
            $validated = $request->validated();
            $validated['user_id'] = auth()->user()->id;
            if(!$this->friendshipRepository->friendshipIsExist($validated['user_id'],$validated['friend_id'])){
                $validated['status'] = FriendshipStatus::Pending;
                $friendship = $this->friendshipRepository->create($validated);
                return new FriendshipResource($friendship);
            }
            return response()->json([
                'error' => 'Friendship is existed'
            ]);
        }
        return response()->json([
            "error" => "Unauthenticated"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        $friendship = $this->friendshipRepository->find($id);
        if($friendship) {
            return new FriendshipResource($friendship);
        }
        return response()->json([
            "error" => "Friendship not found"
        ],404);
    }

    public function getFriendShip(Request $request) {
        $user_id = $request->query('user_id');
        $friend_id = $request->query('friend_id');
        $friendship = $this->friendshipRepository->getFriendShip($user_id,$friend_id);
        if($friendship){
            return new FriendshipResource($friendship);
        }
        return response()->json([
            "error" => "Friendship not found"
        ]);
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

    public function updateFriendshipStatus(UpdateFriendshipStatusRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $friendship = $this->friendshipRepository->updateFriendshipStatus($validated['user_id'],$validated['friend_id'],$validated['status']);
        if($friendship){
            return new FriendshipResource($friendship);
        }
        return response()->json([
            'error' => 'Friendship not found',
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

    public function deleteFriendship(StoreFriendshipRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $friendship = $this->friendshipRepository->getFriendShip($request->user()->id,$validated['friend_id']);
        if($this->authorize('delete',[$friendship,$request->user()])){
            $deleted = $this->friendshipRepository->deleteFriendship($validated['user_id'],$validated['friend_id']);
            if($deleted) {
                return response()->json(["message" => "Delete friendship sucessfully"]);
            }
            return response()->json(["message" => "Friendship not found"], 404); 
        }
        return response()->json([
            'error' => 'Unauthorized'
        ]);
    }

    public function getFriendsByUserId($Request) 
    {
        $user_id = request('user_id');
        $friends = $this->friendshipRepository->getFriendsByUserId(($user_id));
        return UserResource::collection($friends);
    }
}
