<?php declare(strict_types=1);

namespace Package\Application\Game\Finished;

use Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Usecase\Game\Finished\GameFinishedServiceInterface;
use Package\Usecase\Game\Finished\GameFinishedCommand;

class GameFinishedService implements GameFinishedServiceInterface
{
    private $gameRecordTokenRepository;

    public function __construct(GameRecordTokenRepositoryInterface $gameRecordTokenRepository)
    {
        $this->gameRecordTokenRepository = $gameRecordTokenRepository;
    }

    public function handle(GameFinishedCommand $command): void
    {
        $gameToken = new GameToken($command->token);
        $gameRecordToken = $this->gameRecordTokenRepository->getByGameToken($gameToken);

        // https://github.com/sokorahen-szk/warzone-aoe/issues/85
        // TODO: ここにゲームレコードの情報を取得する処理

        // https://github.com/sokorahen-szk/warzone-aoe/issues/85
        // TODO: ここにゲームレコードの情報を更新する処理
        // ステータスの状態を更新時にチェックする。マッチング中のステータスのみ書き換えるようにする。
        // これはRepositoryの責務。

        // https://github.com/sokorahen-szk/warzone-aoe/issues/85
        // TODO: ここにゲーム終了の通知をDiscordに送る処理
    }
}