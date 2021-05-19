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
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\FavoriteController;

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
    // Route::get('/ads/search', [AdController::class, 'searchAds']);
    //To-do : add this to priate route, this is just for testing
    Route::get('ads', [AdController::class, 'index']);
    // change route name with query string
    // Route::get('ads/latest', [AdController::class, 'getLastAds']);
    Route::post('ads/add', [AdController::class, 'store'])->middleware('react');
    Route::get('ads/{id}', [AdController::class, 'show']);
    Route::put('ads/edit/{id}', [AdController::class, 'update']);
    Route::delete('ads/delete/{ad}', [AdController::class, 'destroy']);
    // Change name of theses 2 routes with query strings ?
    Route::get('ads/{id}/checkFavorite', [AdController::class, 'checkFavorite'])->middleware('react');
    Route::get('ads/{id}/handleFavorite', [AdController::class, 'handleFavorite'])->middleware('react');
    Route::get('favorites', [FavoriteController::class, 'index'])->middleware('react');
    ////////////////////// Public routes //////////////////////
    // Auth Routes
    Route::post('register', [AuthController::class, 'register']);
    // Rename with query string
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

    // Alerts routes
    Route::get('alerts', [AlertController::class, 'index']);
    Route::get('alerts/{id}', [AlertController::class, 'show'])->middleware('react');
    Route::post('alerts/add', [AlertController::class, 'store'])->middleware('react');
    Route::put('alerts/edit/{id}', [AlertController::class, 'update'])->middleware('react');
    Route::delete('alerts/delete/{id}', [AlertController::class,'destroy'])->middleware('react');

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

    Route::get('association/ads', [AssociationDashboardController::class, 'index'])->middleware('react');
    Route::get('association/ads/{id}', [AssociationDashboardController::class, 'show'])->middleware('react');
});
