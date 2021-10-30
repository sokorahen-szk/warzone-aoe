<?php declare(strict_types=1);

namespace Package\Application\Game\Finished;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Usecase\Game\Finished\GameFinishedServiceInterface;
use Package\Usecase\Game\Finished\GameFinishedCommand;
use DB;
use Exception;

class GameFinishedService implements GameFinishedServiceInterface
{
    private $gameRecordTokenRepository;
    private $gameRecordRepository;

    public function __construct(
        GameRecordTokenRepositoryInterface $gameRecordTokenRepository,
        GameRecordRepositoryInterface $GameRecordRepository
        )
    {
        $this->gameRecordTokenRepository = $gameRecordTokenRepository;
        $this->gameRecordRepository = $GameRecordRepository;
    }

    public function handle(GameFinishedCommand $command): void
    {
        $gameToken = new GameToken($command->token);
        $gameRecordToken = $this->gameRecordTokenRepository->getByGameToken($gameToken);

        $gameRecord = $this->gameRecordRepository->getById($gameRecordToken->getGameRecordId());

        if (!$gameRecord->getGameStatusIsMatching()) {
            throw new Exception('マッチング中以外はステータスの変更はできません。');
        }

		try {
			DB::beginTransaction();

            // https://github.com/sokorahen-szk/warzone-aoe/issues/85
            // TODO: ここにゲームレコードの情報を更新する処理
            // ステータスの状態を更新時にチェックする。マッチング中のステータスのみ書き換えるようにする。
            // これはRepositoryの責務。

            // プレイヤーの情報をtrueSkillに問合せし、それを元にUpdate後のデータを得る

            // game_record.idに紐づく、player_memoriesのデータを更新する。

            // 各プレイヤーのplayers情報を更新する。rate, mu, sigma, 勝ち負け数、ゲーム数、連勝、連敗など。

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			throw $e;
		}

        // https://github.com/sokorahen-szk/warzone-aoe/issues/85
        // TODO: ここにゲーム終了の通知をDiscordに送る処理
    }
}