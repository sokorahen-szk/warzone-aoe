<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Package\Usecase\Player\GetList\PlayerGetListServiceInterface;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeServiceInterface;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeCommand;
use Package\Usecase\Player\GetProfile\PlayerGetProfileServiceInterface;
use Package\Usecase\Player\GetProfile\PlayerGetProfileCommand;

use App\Http\Requests\Game\GameRaitingRequest;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordMuEnabled;

class PlayerController extends Controller
{
    use ApiResponser;

    /**
     * プレイヤー情報取得する
     * @param PlayerGetListServiceInterface $interactor
     * @return json(...)
     */
    public function list(PlayerGetListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), 'プレイヤーの一覧を取得しました。');
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
            $request->begin_date,
            $request->input('end_date', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result, 'プレイヤーレーティングを取得しました。');
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

        return $this->validResponse($result, 'プレイヤー基本情報を取得しました。');
    }
}
