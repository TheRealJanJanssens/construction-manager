<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\AuthController;
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
    Route::apiResource('users', UserController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('projects', ProjectController::class);

    //Units
    Route::get('units/{unit}/projects', [UnitController::class, 'projects']);
});
