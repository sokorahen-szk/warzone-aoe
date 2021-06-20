<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GamePackageController;
use App\Http\Controllers\GameMapController;

class GameRoutes {
	public static function routes()
	{
		Route::prefix('game')->group(function() {
			/**
			 * ゲームパッケージ一覧取得
			 * GET /api/game/package/list
			 */
			Route::get('package/list', [GamePackageController::class, 'list'])->name('game.package.list');

			/**
			 * ゲームマップ一覧取得
			 * GET /api/game/map/list
			 */
			Route::get('map/list', [GameMapController::class, 'list'])->name('game.map.list');
		});
	}
}