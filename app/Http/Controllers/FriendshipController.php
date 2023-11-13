<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\FriendshipRepositoryInterface;
use App\Models\Friendship;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFriendshipRequest;
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
    public function index()
    {
        //
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
        dd($friendship);
    }

    /**
     * Display the specified resource.
     */
    public function show(Friendship $friendship)
    {
        //
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
    public function update(Request $request, Friendship $friendship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friendship $friendship)
    {
        //
    }
}
