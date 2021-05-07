<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use \Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface;
use \Package\Usecase\Game\GameMap\GetList\GameMapListCommand;
use \App\Http\Requests\Game\GameMapListRequest;

class GameMapController extends Controller
{
    use ApiResponser;

    public function list(GameMapListServiceInterface $interactor, GameMapListRequest $request)
    {
        $result = $interactor->handle(new GameMapListCommand($request->game_package_id));
        return $this->validResponse($result->getVars(), '取得しました。');
    }
}
