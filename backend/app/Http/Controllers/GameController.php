<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Package\Usecase\Game\GamePackage\GetList\GamePackageListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListServiceInterface;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionServiceInterface;
use Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListCommand;
use Package\Usecase\Game\Matching\GameMatchingServiceInterface;
use Package\Usecase\Game\Finished\GameFinishedCommand;
use Package\Usecase\Game\Finished\GameFinishedServiceInterface;

use App\Http\Requests\Game\GameHistoryListRequest;
use App\Http\Requests\Game\GameCreateTeamDivisionRequest;
use App\Http\Requests\Game\GameFinishedRequest;
use App\Http\Requests\Game\GameMatchingRequest;

use Package\Usecase\Game\TeamDivision\GameTeamDivisionCommand;
use Package\Usecase\Game\Matching\GameMatchingCommand;

use Auth;
use Package\Usecase\Game\GameRule\GetList\GameRuleListServiceInterface;

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
	 * ゲームルール一覧取得
	 * GET /api/game/rule/list
     *
     * @param GameRuleListServiceInterface $interactor
     * @return json(...)
     */
    public function listRule(GameRuleListServiceInterface $interactor)
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
            $request->input('end_date', null),
            $request->input('status', null),
        );
        $result = $interactor->handle($command);
        return $this->validResponse($result->getVars());
    }

    /**
     * ゲームチーム分け
     * POST /api/game/create/team_division
     * @param GameTeamDivisionServiceInterface $interactor
     * @param GameCreateTeamDivisionRequest $request
     * @return json(...)
     */
    public function teamDivision(GameTeamDivisionServiceInterface $interactor, GameCreateTeamDivisionRequest $request)
    {
        $command = new GameTeamDivisionCommand(
            $request->player_ids,
            $request->game_package_id,
            $request->rule_id,
            $request->map_id
        );

        $result = $interactor->handle($command);
        return $this->validResponse($result->getVars());
    }

    /**
     * ゲーム開始
     * POST /api/game/create/matching
     * @param GameMatchingServiceInterface $interactor
     * @param GameMatchingRequest $request
     * @return json(...)
     */
    public function matching(GameMatchingServiceInterface $interactor, GameMatchingRequest $request)
    {
        $userId = null;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $command = new GameMatchingCommand(
            $userId,
            $request->player_ids,
            $request->game_package_id,
            $request->rule_id,
            $request->map_id
        );

        $result = $interactor->handle($command);
        return $this->validResponse($result);
    }

    public function finished(GameFinishedServiceInterface $interactor, GameFinishedRequest $request)
    {
        $command = new GameFinishedCommand(
            $request->token,
            $request->status,
            $request->input('winning_team', null)
        );

        $interactor->handle($command);
        return $this->validResponse([]);
    }
}
