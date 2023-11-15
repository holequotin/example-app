<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipController;
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
    Route::patch("/posts/{post}",[PostController::class,'update']);
    Route::delete("/posts/{post}",[PostController::class,'destroy']);
});

Route::prefix('fake')->group(function () {
    Route::post("/users",[UserController::class,'create']);
    Route::post("/posts/{id}",[PostController::class,'create']);
});

Route::resource('comments',CommentController::class);
Route::resource('friendship',FriendshipController::class);

Route::prefix('friends')->group(function () {
    Route::get('/',[FriendshipController::class,'getFriendShip']);
    Route::get('/{userId}', [FriendshipController::class,'getFriendsByUserId']);
    Route::put('/',[FriendshipController::class,'updateFriendshipStatus']);
    Route::delete('/',[FriendshipController::class,'deleteFriendship']);
});
Route::get('hello/{userId}', [UserController::class,'hello'])->name("testApi");
