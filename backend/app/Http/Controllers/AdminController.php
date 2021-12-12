<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AdminUserListRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Traits\ApiResponser;
use App\Http\Requests\Admin\RegisterRequestUpdateRequest;
use Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestGetListServiceInterface;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateServiceInterface;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateCommand;
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

    public function createUser() {
        return "impl me";
    }

    public function updateUser(AdminUserUpdateServiceInterface $interactor, int $userId, AdminUserUpdateRequest $request)
    {
        $interactor->handle(new AdminUserUpdateCommand(
            $userId,
            $request->user_name,
            $request->input('email', null),
            $request->input('password', null),
            $request->input('steam_id', null),
            $request->input('twitter_id', null),
            $request->input('web_site_url', null),
            $request->input('status', null),
            $request->input('role_id', null)
        ));

        return $this->validResponse([]);
    }
}
