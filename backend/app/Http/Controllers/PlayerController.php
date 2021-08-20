<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordMuEnabled;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeCommand;
use Package\Usecase\Player\GetProfile\PlayerGetProfileCommand;
use Package\Usecase\Player\ListHistory\PlayerListHistoryCommand;
use Package\Usecase\Player\PlayerList\PlayerListCommand;

use App\Http\Requests\Game\GameRaitingRequest;
use App\Http\Requests\Game\GameHistoryListRequest;
use App\Http\Requests\Player\PlayerListRequest;
use Package\Usecase\Player\ListHistory\PlayerListHistoryServiceInterface;
use Package\Usecase\Player\PlayerList\PlayerListServiceInterface;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeServiceInterface;
use Package\Usecase\Player\GetProfile\PlayerGetProfileServiceInterface;

class PlayerController extends Controller
{
    use ApiResponser;

    /**
     * プレイヤー情報取得する
     * @param PlayerListServiceInterface $interactor
     * @param PlayerListRequest $request
     * @return json(...)
     */
    public function list(PlayerListServiceInterface $interactor, PlayerListRequest $request)
    {
        $command = new PlayerListCommand(
            $request->game_package_id
        );
        $result = $interactor->handle($command);
        return $this->validResponse($result->getVars());
    }

    /**
     * プレイヤーのレーティングを取得する
     * @param GameRecordListByDateRangeServiceInterface $interactor
     * @param GameRaitingRequest $request
     * @param int $userId
     * @return json(...)
     */
    public function raiting(GameRecordListByDateRangeServiceInterface $interactor, GameRaitingRequest $request, $userId)
    {
        $command = new GameRecordListByDateRangeCommand(
            $userId,
            GameRecordMuEnabled::RAITING_MU_DISABLED,
            $request->game_package_id,
            $request->begin_date,
            $request->input('end_date', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result);
    }

    /**
     * プレイヤー基本情報取得
     * @param PlayerGetProfileServiceInterface $interactor
     * @param int $userId
     * @return json(...)
     */
    public function profile(PlayerGetProfileServiceInterface $interactor, $userId)
    {
        $command = new PlayerGetProfileCommand(
            $userId
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result);
    }

    /**
     * プレイヤー対戦履歴
     * @param PlayerListHistoryServiceInterface $interactor
     * @param GameHistoryListRequest $request
     * @param int $userId
     * @return json(...)
     */
    public function history(PlayerListHistoryServiceInterface $interactor, GameHistoryListRequest $request, $userId)
    {
        $command = new PlayerListHistoryCommand(
            $userId,
            $request->input('page', 1),
            $request->input('limit', 10),
            $request->game_package_id,
            $request->input('begin_date', null),
            $request->input('end_date', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result);
    }
}
