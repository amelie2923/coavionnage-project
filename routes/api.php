<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PlaneTicketController;
use App\Http\Controllers\Api\TypeSearchController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AssociationDashboardController;


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
    Route::post('ads/add', [AdController::class, 'store'])->middleware('react');
    Route::get('ads/{id}', [AdController::class, 'show'])->middleware('react');
    Route::put('ads/edit/{id}', [AdController::class, 'update']);
    Route::delete('ads/delete/{ad}', [AdController::class, 'destroy']);
    Route::get('ads/{id}/checkFavorite', [AdController::class, 'checkFavorite'])->middleware('react');
    Route::get('ads/{id}/handleFavorite', [AdController::class, 'handleFavorite'])->middleware('react');
    ////////////////////// Public routes //////////////////////
    // Auth Routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('association-register', [AuthController::class, 'registerAssociation']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('password/forgot-password', [AuthController::class, 'sendResetLinkResponse'])->name('passwords.sent');
    Route::post('password/reset', [AuthController::class, 'sendResetResponse'])->name('passwords.reset');

    /* To do -> add to private routes */
    // Ads Routes -> add a middleware role -> and add to protected routes
    // Route::middleware(['association'])->group(function () {
        // Route::put('ads/edit/{ad}', [AdController::class, 'update']);
        // Route::delete('ads/delete/{ad}', [AdController::class, 'destroy']);
    // });

    /* To do -> add to private routes */
    // PlaneTickets routes -> add a middleware role -> and add to protected routes
    // Route::middleware(['traveller'])->group(function () {
        Route::post('planetickets/add', [PlaneTicketController::class, 'store'])->middleware('react');
        Route::put('planetickets/edit/{id}', [PlaneTicketController::class, 'update'])->middleware('react');
        Route::delete('planetickets/delete/{id}', [PlaneTicketController::class,'destroy'])->middleware('react');
    // });

    // Roles routes
    Route::get('roles', [RoleController::class, 'index']);

    ////////////////////// Protected routes //////////////////////
    // Auth Routes
    Route::post('logout', [AuthController::class, 'logout']);

    //Plane tickets Routes
    Route::get('planetickets', [PlaneTicketController::class, 'index']);
    Route::get('planetickets/{id}', [PlaneTicketController::class, 'show']);

    // Users Routes
    Route::get('/users/profile', [UserController::class, 'profile'])->middleware('react');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('react');
    Route::get('users', [UserController::class, 'index']);
    //Type search routes
    Route::get('typesearchs', [TypeSearchController::class, 'index']);

    // Route::get('test', [UserController::class, 'test'])->middleware('react');

    Route::get('notifications', [NotificationController::class, 'index'])->middleware('react');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->middleware('react');

    // Route::get('association-ads', [AssociationDashboardController::class, 'index'])->middleware('react');
    // Route::get('association-ads/{id}', [AssociationDashboardController::class, 'show'])->middleware('react');

    Route::get('/ads/search/{date}', [AdController::class, 'searchAds']);
});
