<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\AccountGameStatusUpdateRequest;
use App\Http\Requests\Admin\AdminPlayerListRequest;
use App\Http\Requests\Admin\AdminPlayerUpdateRequest;
use App\Http\Requests\Admin\AdminUserListRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Traits\ApiResponser;
use App\Http\Requests\Admin\RegisterRequestUpdateRequest;
use Package\Usecase\Admin\Game\Update\AdminGameUpdateCommand;
use Package\Usecase\Admin\Game\Update\AdminGameUpdateServiceInterface;
use Package\Usecase\Admin\Player\ListData\AdminPlayerListCommand;
use Package\Usecase\Admin\Player\ListData\AdminPlayerListServiceInterface;
use Package\Usecase\Admin\Player\Update\AdminPlayerUpdateCommand;
use Package\Usecase\Admin\Player\Update\AdminPlayerUpdateServiceInterface;
use Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestGetListServiceInterface;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateServiceInterface;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateCommand;
use Package\Usecase\Admin\User\Create\AdminUserCreateServiceInterface;
use Package\Usecase\Admin\User\Create\AdminUserCreateCommand;
use Package\Usecase\Admin\User\ListData\AdminUserListCommand;
use Package\Usecase\Admin\User\ListData\AdminUserListServiceInterface;
use Package\Usecase\Admin\User\Update\AdminUserUpdateCommand;
use Package\Usecase\Admin\User\Update\AdminUserUpdateServiceInterface;

class AdminController extends Controller
{
    use ApiResponser;

    public function listNewCreateRequest(AdminRegisterRequestGetListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), '取得しました。');
    }

    public function updateNewCreateRequest(AdminRegisterRequestUpdateServiceInterface $interactor, int $registerId, RegisterRequestUpdateRequest $request)
    {
        $result = $interactor->handle(new AdminRegisterRequestUpdateCommand(
            $registerId,
            \Auth::user()->id,
            $request->status,
            $request->input('remarks', null)
        ));

        return $this->validResponse($result, '新規登録リクエストを更新しました。');
    }

    public function listUser(AdminUserListServiceInterface $interactor, AdminUserListRequest $request)
    {
        $result = $interactor->handle(new AdminUserListCommand(
            $request->input('page', 1),
            $request->input('limit', 10)
        ));

        return $this->validResponse($result->getVars(), '取得しました。');
    }

    public function createUser(AdminUserCreateServiceInterface $interactor, AdminUserCreateRequest $request) {
        $interactor->handle(new AdminUserCreateCommand(
            $request->user_name,
            $request->player_name,
            $request->role_id,
            $request->password,
            $request->input('game_packages', null),
            $request->input('steam_id', null)
        ));

        return $this->validResponse([], 'ユーザ情報を作成しました。');
    }

    public function updateUser(AdminUserUpdateServiceInterface $interactor, AdminUserUpdateRequest $request, int $userId)
    {
        $interactor->handle(new AdminUserUpdateCommand(
            $userId,
            $request->user_name,
            $request->role_id,
            $request->input('email', null),
            $request->input('password', null),
            $request->input('steam_id', null),
            $request->input('twitter_id', null),
            $request->input('web_site_url', null),
            $request->status,
            $request->input('game_packages', null),
        ));

        return $this->validResponse([], 'ユーザ情報を更新しました。');
    }

    public function updateGame(AdminGameUpdateServiceInterface $interactor, AccountGameStatusUpdateRequest $request, int $gameRecordId)
    {
        $interactor->handle(new AdminGameUpdateCommand(
            $gameRecordId,
            $request->status,
            $request->input('winning_team', null)
        ));

        return $this->validResponse([]);
    }

    public function listPlayer(AdminPlayerListServiceInterface $interactor, AdminPlayerListRequest $request)
    {
        $result = $interactor->handle(new AdminPlayerListCommand(
            $request->input('page', 1),
            $request->input('limit', 10)
        ));

        return $this->validResponse($result->getVars(), 'プレイヤー情報を取得しました。');
    }

    public function updatePlayer(AdminPlayerUpdateServiceInterface $interactor, AdminPlayerUpdateRequest $request, int $playerId)
    {
        $interactor->handle(new AdminPlayerUpdateCommand(
            $playerId,
            $request->player_name,
            $request->mu,
            $request->sigma,
            $request->rate,
            $request->enabled
        ));

        return $this->validResponse([], 'プレイヤー情報を更新しました。');
    }
}
