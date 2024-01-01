<?php

use App\Http\Controllers\API\V1\AssetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CommentController;
use App\Http\Controllers\API\V1\ConversationController;
use App\Http\Controllers\API\V1\MessageController;
use App\Http\Controllers\API\V1\PostController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\UnitController;
use App\Http\Controllers\API\V1\UserController;

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

//Public V1 Routes
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function() {
    Route::post('/login', [AuthController::class, 'login']);
});

//Protected V1 Routes
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('assets', AssetController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('conversations', ConversationController::class);

    //Post
    Route::get('posts/{post}/comments', [PostController::class, 'comments']);
    Route::post('posts/{post}/comments', [PostController::class, 'addComment']);

    //Users
    Route::get('users/{user}/units', [UserController::class, 'units']);
    Route::get('users/{user}/conversations', [UserController::class, 'conversations']);

    //Units
    Route::get('units/{unit}/users', [UnitController::class, 'users']);
    Route::get('units/{unit}/projects', [UnitController::class, 'projects']);

    //Conversations
    Route::get('conversations/{conversation}/messages', [ConversationController::class, 'messages']);
    Route::post('conversations/{conversation}/messages', [ConversationController::class, 'addMessage']);
});
