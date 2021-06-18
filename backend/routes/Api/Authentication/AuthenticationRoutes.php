<?php

namespace Routes\Api\Authentication;

use Illuminate\Support\Facades\Route;
use Routes\Api\Authentication\AccountRoutes;
use Routes\Api\Authentication\AdminRoutes;
use Routes\Api\Authentication\AuthRoutes;

class AuthenticationRoutes {
	public static function routes() {
		Route::group(['middleware' => 'auth:api'], function () {
            AccountRoutes::routes();
            AdminRoutes::routes();
            AuthRoutes::routes();
		});
	}
}