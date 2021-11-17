<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Http\Requests\Admin\RegisterRequestUpdateRequest;
use Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestGetListServiceInterface;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateServiceInterface;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateCommand;
use Package\Usecase\Admin\User\ListData\AdminUserListServiceInterface;

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

    public function listUser(AdminUserListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), '取得しました。');
    }
}
