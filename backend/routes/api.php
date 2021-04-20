<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
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


/**
 * 未ログインユーザ向けAPI
 */
Route::group(['middleware' => 'api'], function() {
  Route::prefix('auth')->group(function() {
    /**
     * POST /api/auth/login
     */
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
  });
});

/**
 * ログイン済ユーザ向けAPI
 */
Route::group(['middleware' => 'auth:api'], function () {
  Route::prefix('user')->group(function() {
    /**
     * GET /api/user/profile
     */
    Route::get('profile', [UserController::class, 'getProfile'])->name('user.profile');
  });

  Route::prefix('auth')->group(function() {
    /**
     * POST /api/auth/logout
     */
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
  });
});