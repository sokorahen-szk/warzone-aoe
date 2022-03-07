<?php

namespace Routes\Api\Unauthenticated;

use Illuminate\Support\Facades\Route;

class UnauthenticatedRoutes {
	public static function routes()
	{
		Route::middleware('api')->group( function () {
			AuthRoutes::routes();
			PlayerRoutes::routes();
			GameRoutes::routes();
			AccountRoutes::routes();
		});
	}
}