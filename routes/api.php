<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
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
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('forget_password',[AuthController::class,'forgetPassword']);
    Route::post('reset_password',[AuthController::class,'resetPassword']);
});

Route::controller(PostController::class)->group(function () {
    Route::get("/posts/{id}",[PostController::class,'show']);
    Route::get("/posts",[PostController::class,'index']);
    Route::post("/posts",[PostController::class,'store'])->middleware('auth');
    Route::patch("/posts/{post}",[PostController::class,'update'])->middleware('auth');
    Route::delete("/posts/{post}",[PostController::class,'destroy'])->middleware('auth');
});

Route::prefix('fake')->group(function () {
    Route::post("/users",[UserController::class,'create']);
    Route::post("/posts/{id}",[PostController::class,'create']);
});

Route::resource('comments',CommentController::class)->middleware('auth');
Route::resource('friendship',FriendshipController::class)->middleware('auth');

Route::prefix('friends')->middleware('auth')->group(function () {
    Route::get('/',[FriendshipController::class,'getFriendShip']);
    Route::post('/', [FriendshipController::class,'getFriends']);
    Route::put('/',[FriendshipController::class,'updateFriendshipStatus']);
    Route::delete('/',[FriendshipController::class,'deleteFriendship']);
});

Route::prefix('reactions')->middleware('auth')->group(function () {
    Route::get('/{postId}',[ReactionController::class,'getReactionByPost']);
    Route::post('/',[ReactionController::class,'store']);
    Route::patch('/',[ReactionController::class,'update']);
    Route::delete('/',[ReactionController::class,'delete']);
});
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/{user_id}/friends',[FriendshipController::class,'getFriendsByUserId']);
});
Route::get('hello/{userId}', [UserController::class,'hello'])->name("testApi");
Route::get('users',[UserController::class,'show'])->name('getUsers');
