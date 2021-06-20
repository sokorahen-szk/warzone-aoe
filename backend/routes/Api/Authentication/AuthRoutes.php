<?php

namespace Routes\Api\Authentication;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

class AuthRoutes {
	public static function routes()
	{
        Route::prefix('auth')->group(function() {
            /**
             * ログアウト
             * POST /api/auth/logout
             */
            Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        });
	}
}