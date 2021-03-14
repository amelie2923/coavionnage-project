<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PlaneTicketController;


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
    //Ads Routes
    //To-do : add this to priate route, this is just for testing
    Route::get('ads', [AdController::class, 'index']);
    Route::post('ads/add', [AdController::class, 'store']);
    Route::get('ads/{ad}', [AdController::class, 'show']);
    Route::put('ads/edit/{ad}', [AdController::class, 'update']);
    Route::delete('ads/delete/{ad}', [AdController::class, 'destroy']);
    ////////////////////// Public routes //////////////////////
    // Auth Routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('password/forgot-password', [AuthController::class, 'sendResetLinkResponse'])->name('password.sent');
    Route::post('password/reset', [AuthController::class, 'sendResetResponse'])->name('password.reset');

    /* To do -> add to private routes */
    // Ads Routes -> add a middleware role -> and add to protected routes
    Route::middleware(['association'])->group(function () {
        // Route::put('ads/edit/{ad}', [AdController::class, 'update']);
        // Route::delete('ads/delete/{ad}', [AdController::class, 'destroy']);
    });

    /* To do -> add to private routes */
    // PlaneTickets routes -> add a middleware role -> and add to protected routes
    Route::middleware(['traveller'])->group(function () {
        Route::post('planetickets/add', [PlaneTicketController::class, 'store']);
        Route::put('planetickets/edit/{id}', [PlaneTicketController::class, 'update']);
        Route::delete('planetickets/delete/{id}', [PlaneTicketController::class,'destroy']);
    });

    // Roles routes
    Route::get('roles', [RoleController::class, 'index']);

    ////////////////////// Protected routes //////////////////////
    Route::middleware('auth:api')->group( function () {
    // Auth Routes
    Route::post('logout', [AuthController::class, 'logout']);

    //Plane tickets Routes
    Route::get('planetickets', [PlaneTicketController::class, 'index']);
    Route::get('planetickets/{id}', [PlaneTicketController::class, 'show']);

    // Users Routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('user', [UserController::class, 'show']);
    });
});
