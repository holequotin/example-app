<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    function hello(Request $request, $userId)
    {
        return response()->json(["message" => "Hello World","userId" => $userId]);
    }
    
    public function create(Request $request)
    {
        $users = User::factory()
                    ->count(5)
                    ->create();
        return UserResource::collection($users);
    }

    public function show(Request $request)
    {
        $user_id = request('user_id');
        $user = User::find($user_id);
        return new UserResource($user);
    }
}
