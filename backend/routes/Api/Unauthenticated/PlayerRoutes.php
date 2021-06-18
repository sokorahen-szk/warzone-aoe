<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

class PlayerRoutes {
	public static function routes()
	{
		Route::prefix('player')->group(function() {
			/**
			 * プレイヤー一覧取得する
			 * GET /api/player/list
			 */
			Route::get('list', [PlayerController::class, 'list'])->name('player.list');

			/**
			 * プレイヤーのレート情報を取得
			 * GET /api/player/rating/{id}
			 */
			Route::get('raiting/{id}', [PlayerController::class, 'raiting'])
			  ->name('player.rating')
			  ->where('id', '^[0-9]+$');
		});
	}
}