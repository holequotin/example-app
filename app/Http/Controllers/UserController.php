<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    function hello(Request $request, $userId)
    {
        return response()->json(["message" => "Hello World","userId" => $userId]);
    }
}
