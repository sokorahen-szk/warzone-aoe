<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PlayerController;

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
     * ログイン
     * POST /api/auth/login
     */
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    /**
     * 新規登録
     * POST /api/auth/register
     */
    Route::post('register', [AccountController::class, 'registration'])->name('auth.register');
  });

  Route::prefix('player')->group(function() {
    /**
     * プレイヤー一覧取得する
     * GET /api/player/list
     */
    Route::get('list', [PlayerController::class, 'list'])->name('player.list');
  });
});

/**
 * ログイン済ユーザ向けAPI
 */
Route::group(['middleware' => 'auth:api'], function () {
  Route::prefix('account')->group(function() {
    /**
     * アカウント情報を取得する
     * POST /api/account/profile
     */
    Route::get('profile', [AccountController::class, 'show'])->name('account.profile');

    /**
     * アバター更新
     * POST /api/account/avator/edit
     */
    Route::post('avator/edit', [AccountController::class, 'updateAvator'])->name('account.avator.edit');
  });

  Route::prefix('auth')->group(function() {
    /**
     * ログアウト
     * POST /api/auth/logout
     */
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
  });
});