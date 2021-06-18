<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GamePackageController;
use App\Http\Controllers\GameMapController;

class UnauthenticatedRoutes {
	public static function routes()
	{
		Route::group(['middleware' => 'api'], function() {
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
		      });

	}
}