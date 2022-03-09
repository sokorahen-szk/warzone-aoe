<?php

namespace Routes\Api\Authentication;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

class AdminRoutes {
	public static function routes()
	{
        Route::prefix('admin')->group(function() {
            /**
             * 新規登録リクエスト一覧取得
             * GET /api/admin/request
             */
            Route::get('request', [AdminController::class, 'listNewCreateRequest'])->name('admin.request');

            /**
             * 新規登録リクエスト更新
             * POST /api/admin/request/{registerId}
             */
            Route::post('request/{registerId}', [AdminController::class, 'updateNewCreateRequest'])
            ->name('admin.request.update')
            ->where('registerId', '^[0-9]+$');

            /**
             * ユーザ一覧取得
             * GET /api/admin/user
             */
            Route::get('user', [AdminController::class, 'listUser'])->name('admin.user');

            /**
             * ユーザ新規作成
             * POST /api/admin/user/create
             */
            Route::post('user/create', [AdminController::class, 'createUser'])->name('admin.user.create');

            /**
             * ユーザ更新
             * POST /api/admin/user/{userId}
             */
            Route::post('user/{userId}', [AdminController::class, 'updateUser'])
            ->name('admin.user.update')
            ->where('userId', '^[0-9]+$');

            /**
             * 勝敗更新
             * POST /api/admin/game/{gameRecordId}
             */
            Route::post('game/{gameRecordId}', [AdminController::class, 'updateGame'])
            ->name('admin.update.game')
            ->where('gameRecordId', '^[0-9]+$');

            /**
             * プレイヤー更新
             * POST /api/admin/player/{playerId}
             */
            Route::post('player/{playerId}', [AdminController::class, 'updatePlayer'])
            ->name('admin.update.player')
            ->where('playerId', '^[0-9]+$');
        });
	}
}
