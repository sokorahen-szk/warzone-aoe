<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use \Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface;
use \App\Http\Requests\Game\GameMapListRequest;

class GameMapController extends Controller
{
    use ApiResponser;

    public function list(GameMapListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), '取得しました。');
    }
}
