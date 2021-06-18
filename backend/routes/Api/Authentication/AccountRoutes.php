<?php

namespace Routes\Api\Authentication;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

class AccountRoutes {
	public static function routes()
    {
        Route::prefix('account')->group(function() {
            /**
             * アカウント情報を取得する
             * POST /api/account/profile
             */
            Route::get('profile', [AccountController::class, 'show'])->name('account.profile');

            /**
             * プロフィール更新
             * POST /api/account/profile/edit
             */
            Route::post('profile/edit', [AccountController::class, 'changeProfile'])->name('account.profile.edit');

            /**
             * アバター更新
             * POST /api/account/avator/edit
             */
            Route::post('avator/edit', [AccountController::class, 'updateAvator'])->name('account.avator.edit');

            /**
             * アバター削除
             * POST /api/account/avator/delete
             */
            Route::post('avator/delete', [AccountController::class, 'deleteAvator'])->name('account.avator.delete');

            /**
             * ユーザ退会
             * POST /api/account/withdrawal
             */
            Route::post('withdrawal', [AccountController::class, 'withdrawal'])->name('account.withdrawal');

            /**
             * 個人レーティング
             * GET /api/account/raiting
             */
            Route::get('raiting', [AccountController::class, 'raiting'])->name('account.raiting');
        });
    }
}