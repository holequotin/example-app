<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register',[AuthController::class,'register']);
});

Route::controller(PostController::class)->group(function () {
    Route::get("/posts/{id}",[PostController::class,'show']);
    Route::get("/posts",[PostController::class,'index']);
    Route::post("/posts",[PostController::class,'store']);
    Route::put("/posts/{post}",[PostController::class,'update']);
    Route::delete("/posts/{post}",[PostController::class,'destroy']);
});

Route::get('hello/{userId}', [UserController::class,'hello'])->name("testApi");
