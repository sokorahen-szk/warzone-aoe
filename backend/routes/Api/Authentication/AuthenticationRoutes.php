<?php

namespace Routes\Api\Authentication;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;

class AuthenticationRoutes {
	public static function routes() {
		Route::group(['middleware' => 'auth:api'], function () {
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

			Route::prefix('auth')->group(function() {
			  /**
			   * ログアウト
			   * POST /api/auth/logout
			   */
			  Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
			});
		      });
	}
}