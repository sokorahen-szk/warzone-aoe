<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Package\Usecase\Game\GamePackage\GetList\GamePackageListServiceInterface;
use Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListCommand;
use App\Http\Requests\Game\GameHistoryListRequest;

class GameController extends Controller
{
    use ApiResponser;

    /**
     * ゲームパッケージ一覧取得
     * GET /api/game/package/list
     *
     * @param GamePackageListServiceInterface $interactor
     * @return json(...)
     */
    public function listPackage(GamePackageListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars());
    }

    /**
     * ゲームマップ一覧取得
     * GET /api/game/map/list
     *
     * @param GameMapListServiceInterface $interactor
     * @return json(...)
     */
    public function listMap(GameMapListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars());
    }

    /**
     * ゲーム履歴
     * GET /api/game/history/list
     * @param GameHistoryListServiceInterface $interactor
     * @param GameHistoryListRequest $request
     * @return json(...)
     */
    public function listHistory(GameHistoryListServiceInterface $interactor, GameHistoryListRequest $request)
    {
        $command = new GameHistoryListCommand(
            $request->input('page', 1),
            $request->input('limit', 10),
            $request->input('begin_date', null),
            $request->input('end_date', null)
        );
        $result = $interactor->handle($command);
        return $this->validResponse($result->getVars());
    }
}
