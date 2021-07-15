<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

class GameRoutes {
	public static function routes()
	{
		Route::prefix('game')->group(function() {
			/**
			 * ゲームパッケージ一覧取得
			 * GET /api/game/package/list
			 */
			Route::get('package/list', [GameController::class, 'listPackage'])->name('game.package.list');

			/**
			 * ゲームマップ一覧取得
			 * GET /api/game/map/list
			 */
			Route::get('map/list', [GameController::class, 'listMap'])->name('game.map.list');

			/**
			 * ゲーム履歴
			 * GET /api/game/history/list
			 */
			Route::get('history/list', [GameController::class, 'listHistory'])->name('game.history.list');

			/**
			 * ゲームチーム分け
			 * POST /api/game/create/team_division
			 */
			Route::post('/create/team_division', [GameController::class, 'teamDivision'])->name('game.create.team_division');
		});
	}
}