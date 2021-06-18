<?php

use Illuminate\Support\Facades\Route;

use Routes\Api\Unauthenticated\UnauthenticatedRoutes;
use Routes\Api\Authentication\AuthenticationRoutes;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * 未ログインユーザ向けAPI
 */
UnauthenticatedRoutes::routes();

/**
 * ログイン済ユーザ向けAPI
 */
AuthenticationRoutes::routes();