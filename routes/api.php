<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['json.response']], function () {
    // Public routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::resource('ads', AdController::class);

    //Protected routes
    Route::middleware('auth:api')->group( function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('users', [UserController::class, 'index']);
        Route::get('user', [UserController::class, 'show']);
    });
});