<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

class AuthRoutes {
	public static function routes()
	{
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
	}
}