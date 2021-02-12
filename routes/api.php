<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
// use App\Http\Controllers\Api\ForgotPasswordController;
// use App\Http\Controllers\Api\ResetPasswordController;

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
    ////////////////////// Public routes //////////////////////
    // Auth Routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('password/forgot-password', [AuthController::class, 'sendResetLinkResponse'])->name('password.sent');
    Route::post('password/reset', [AuthController::class, 'sendResetResponse'])->name('password.reset');

    // Ads Routes -> add a middleware role -> and add to protected routes
    Route::middleware(['association'])->group(function () {
        Route::get('ads', [AdController::class, 'index']);
        Route::get('ads/{ad}', [AdController::class, 'show']);
        Route::post('ads/add', [AdController::class, 'store']);
        Route::put('ads/edit/{ad}', [AdController::class, 'update']);
        Route::delete('ads/delete/{ad}', [AdController::class, 'destroy']);
    });

    // Flights routes -> add a middleware role -> and add to protected routes

    // Roles routes
    Route::get('roles', [RoleController::class, 'index']);

    ////////////////////// Protected routes //////////////////////
    Route::middleware('auth:api')->group( function () {
    // Auth Routes
    Route::post('logout', [AuthController::class, 'logout']);

    // Users Routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('user', [UserController::class, 'show']);
    });
});