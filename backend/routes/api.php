<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

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



Route::group(['middleware' => 'api'], function() {
  Route::prefix('auth')->group(function() {
    /**
     * POST /auth/login
     */
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    /**
     * POST /auth/logout
     */
    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
  });
});