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
        });
	}
}