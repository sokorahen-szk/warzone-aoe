<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Package\Usecase\Admin\GetList\AdminRegisterRequestGetListServiceInterface;

class AdminController extends Controller
{
    use ApiResponser;

    public function listNewCreateRequest(AdminRegisterRequestGetListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), '取得しました。');
    }
}
