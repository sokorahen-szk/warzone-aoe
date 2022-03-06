<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AccountController;

class AccountRoutes {
	public static function routes()
	{
		Route::prefix('account')->group(function() {
            /**
             * パスワードリセット　メール送信
             * POST /api/account/password/reset
             */
            Route::post('password/reset', [AccountController::class, 'resetPasswordSendEmail'])->name('account.password.reset.send.email');

            /**
             * パスワードリセット　再発行
             * POST /api/account/password/reset/{token}
             */
            Route::post('password/reset/{token}', [AccountController::class, 'resetPassword'])->name('account.password.reset');
		});
	}
}