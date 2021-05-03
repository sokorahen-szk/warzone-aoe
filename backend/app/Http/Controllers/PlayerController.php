<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Package\Usecase\Player\GetList\PlayerGetListServiceInterface;

class PlayerController extends Controller
{
    use ApiResponser;

    /**
     * プレイヤー情報取得する
     * @param PlayerGetListServiceInterface $interactor
     */
    public function list(PlayerGetListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), '登録が完了しました。');
    }
}
