<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;
use Routes\Api\Unauthenticated\AuthRoutes;
use Routes\Api\Unauthenticated\PlayerRoutes;
use Routes\Api\Unauthenticated\GameRoutes;

class UnauthenticatedRoutes {
	public static function routes()
	{
		Route::group(['middleware' => 'api'], function() {
			AuthRoutes::routes();
			PlayerRoutes::routes();
			GameRoutes::routes();
		});
	}
}