<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Infrastructure\TrueSkill\TrueSkillClient;
use Package\Domain\User\Service\PlayerService;
use Package\Infrastructure\Eloquent\Player\PlayerRepository;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\Repository\PlayerMemoryRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\User\ValueObject\UserId;
use Package\Infrastructure\Eloquent\Game\GameRecordRepository;
use Package\Infrastructure\Eloquent\Player\PlayerMemoryRepository;
use App\Models\GameRecordModel;
use DB;
use Package\Domain\System\ValueObject\Datetime;
use Package\Application\System\UpdateGameSystemService;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\User\Exceptions\UserArgumentException;
use Package\Domain\User\Service\PlayerServiceInterface;
use Package\Usecase\System\UpdateGameSystemServiceInterface;

class ImportWarHistorySeeder extends Seeder
{
    private $updateGameSystemService;
    private $trueSkillClient;
    private $playerRepository;
    private $gameRecordRepository;
    private $playerMemoryRepository;
    private $playerService;

    public function __construct(
        UpdateGameSystemServiceInterface $updateGameSystemService,
        PlayerRepositoryInterface $playerRepository,
        GameRecordRepository $gameRecordRepository,
        PlayerMemoryRepository $playerMemoryRepository,
        PlayerServiceInterface $playerService
    )
    {
        $this->updateGameSystemService = $updateGameSystemService;
        $this->playerRepository = $playerRepository;
        $this->gameRecordRepository = $gameRecordRepository;
        $this->playerMemoryRepository = $playerMemoryRepository;
        $this->playerService = $playerService;

        $this->trueSkillClient = new TrueSkillClient();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dumpHelper = new DumpHelper();
        $warHistoryLines = $dumpHelper->loadDumpFile(dirname(__FILE__) . "/dumps/dump_war_histories");
        $importWarHistories = [];
        foreach ($warHistoryLines as $warHistoryLine) {
            $importWarHistories[] = new ImportWarHistory(
                (int) $warHistoryLine[1],
                $warHistoryLine[2],
                $warHistoryLine[3],
                (int) $warHistoryLine[4],
                (int) $warHistoryLine[12],
                (int) $warHistoryLine[17],
                (int) $warHistoryLine[22],
                (int) $warHistoryLine[27],
                (int) $warHistoryLine[32],
                (int) $warHistoryLine[37],
                (int) $warHistoryLine[42],
                (int) $warHistoryLine[47],
            );
        }

        DB::transaction(function () use ($importWarHistories) {
            SeederHelper::truncate(['game_records', 'player_memories']);

            foreach ($importWarHistories as $importWarHistory) {
                try {
                    $playerCount = $importWarHistory->getPlayerCount();

                    $players = $this->playerService->playerIdsToPlayerEntities($importWarHistory->getPlayerIds());

                    if ($playerCount !== count($players)) {
                        continue;
                    }

                    $trueSkillRequest = $this->toTrueSkillAsDivisionPatternRequest($players);
                    $trueSkillResponse = $this->trueSkillClient->teamDivisionPattern($trueSkillRequest);

                    $gameRecordId = $this->startGame(
                        null,
                        $trueSkillResponse,
                        $importWarHistory->startedDatetime
                    );

                    $this->finishedGame($importWarHistory, $gameRecordId);
                } catch (UserArgumentException $e) {
                    echo $e->getMessage();
                    continue;
                }

                echo $gameRecordId->getValue() . PHP_EOL;
            }
        });
    }

    private function convertGameStatus(int $status): GameStatus
    {
        $gameStatusValue = null;
        switch ($status) {
            case 1: //ゲーム中
                $gameStatusValue = GameStatus::GAME_STATUS_MATCHING;
                break;
            case 5: //試合終了
                $gameStatusValue = GameStatus::GAME_STATUS_FINISHED;
                break;
            case -3: //キャンセル
                $gameStatusValue = GameStatus::GAME_STATUS_CANCELED;
                break;
            case -4: //引き分け
                $gameStatusValue = GameStatus::GAME_STATUS_DRAW;
                break;
            default:
                throw new \Exception(sprintf("移行データのゲームステータスが不正な値です。 status = %d", $status));
        }

        return new GameStatus($gameStatusValue);
    }

    private function startGame(
        ?UserId $userId,
        object $trueSkillResponse,
        Datetime $datetime
    ): GameRecordId
    {
        $team1Players = $this->toPlayers($trueSkillResponse->team1);
        $team2Players = $this->toPlayers($trueSkillResponse->team2);

		$gamePackageId = new GamePackageId(1);
		$gameMapId = new GameMapId(1);
		$gameRuleId = new GameRuleId(1);

        $victoryPrediction = new VictoryPrediction($trueSkillResponse->quality);

        $gameRecordId = $this->gameRecordRepository->create(
            $userId,
            $gamePackageId,
            $gameMapId,
            $gameRuleId,
            $victoryPrediction
        );

        // startedDatetime 書き換える
        $gameRecord = GameRecordModel::find($gameRecordId->getValue());
        $gameRecord->started_at = $datetime->getDatetime();
        $gameRecord->save();

        $this->createPlayerMemories($team1Players, $gameRecordId, new GameTeam(1));
        $this->createPlayerMemories($team2Players, $gameRecordId, new GameTeam(2));

        return $gameRecordId;
    }

    private function finishedGame(ImportWarHistory $importWarHistory, GameRecordId $gameRecordId): void
    {
        $winningTeam = new GameTeam($importWarHistory->winTeam);

        $gameRecord = $this->gameRecordRepository->getById($gameRecordId);
        $this->updateGameSystemService->handle(
            $gameRecord,
            $winningTeam,
            $this->convertGameStatus($importWarHistory->status),
            $importWarHistory->finishedDatetime,
            false,
        );
    }

	private function toTrueSkillAsDivisionPatternRequest(array $players): array
	{
		$data = [];
		foreach ($players as $player) {
			$data[] = [
				'id'	=> $player->getPlayerId()->getValue(),
				'name'	=> $player->getPlayerName()->getValue(),
				'mu'	=> $player->getMu()->getValue(),
				'sigma'	=> $player->getSigma()->getValue(),
			];
		}

		return ['players' => $data];
	}

	private function toPlayers($resources): array
	{
		$players = [];
		foreach ($resources as $resource) {
			$players[] = $this->playerRepository->getById(new PlayerId($resource->id));
		}

		return $players;
	}

	private function createPlayerMemories(array $players, GameRecordId $gameRecordId, GameTeam $gameTeam)
	{
		foreach ($players as $player) {
			$this->playerMemoryRepository->create($gameRecordId, $player, $gameTeam);
		}
	}
}

class ImportWarHistory {
    public function __construct(
        int $status,
        string $startedDatetime,
        string $finishedDatetime,
        int $winTeam,
        int $team1p1,
        int $team1p2,
        int $team1p3,
        int $team1p4,
        int $team2p1,
        int $team2p2,
        int $team2p3,
        int $team2p4
    )
    {
        $this->status = $status;
        $this->startedDatetime = new Datetime($startedDatetime);
        $this->finishedDatetime = new Datetime($finishedDatetime);
        $this->winTeam = $winTeam;
        $this->team1p1 = $team1p1;
        $this->team1p2 = $team1p2;
        $this->team1p3 = $team1p3;
        $this->team1p4 = $team1p4;
        $this->team2p1 = $team2p1;
        $this->team2p2 = $team2p2;
        $this->team2p3 = $team2p3;
        $this->team2p4 = $team2p4;
    }

    public function getPlayerCount(): int
    {
        $cnt = 0;
        for ($i = 1; $i <= 8; $i++) {
            $team = $i <= 4 ? 1 : 2;
            $number = $i <= 4 ? $i : $i - 4;
            $var = sprintf("team%dp%d", $team, $number);
            if ($this->{$var} !== 0) {
                $cnt++;
            }
        }

        return $cnt;
    }

    public function getPlayerIds(): array
    {
        $playerIds = [];
        for ($i = 1; $i <= 8; $i++) {
            $team = $i <= 4 ? 1 : 2;
            $number = $i <= 4 ? $i : $i - 4;
            $var = sprintf("team%dp%d", $team, $number);
            if ($this->{$var} !== 0) {
                $playerIds[] = $this->{$var};
            }
        }

        return $playerIds;
    }
}
