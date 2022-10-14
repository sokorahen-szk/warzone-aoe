<?php

namespace Package\Application\System;

use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Repository\PlayerMemoryRepositoryInterface;
use Package\Domain\User\Service\PlayerServiceInterface;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Infrastructure\Discord\DiscordRepositoryInterface;
use Package\Usecase\System\UpdateGameSystemServiceInterface;
use DB;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

class UpdateGameSystemService implements UpdateGameSystemServiceInterface {
    private $gameRecordRepository;
    private $playerMemoryRepository;
    private $playerService;
    private $discordRepository;
    private $trueSkillClient;

    public function __construct(
        GameRecordRepositoryInterface $GameRecordRepository,
        PlayerMemoryRepositoryInterface $playerMemoryRepository,
        PlayerServiceInterface $playerService,
        DiscordRepositoryInterface $discordRepository
    )
    {
        $this->gameRecordRepository = $GameRecordRepository;
        $this->playerMemoryRepository = $playerMemoryRepository;
        $this->playerService = $playerService;
        $this->discordRepository = $discordRepository;

        // TODO: 今後RepositoryからTrueSkillのデータ取り出すように包括するかもしれない
        $this->trueSkillClient = new TrueSkillClient();
    }

    public function handle(
        GameRecord $gameRecord,
        ?GameTeam $winningTeam,
        GameStatus $gameStatus,
        Datetime $currentDatetime,
        bool $isPushNotification
    ): void
    {
		try {
			DB::beginTransaction();

            $players = $this->pluckPlayer($gameRecord->getPlayerMemories(), $winningTeam, $gameStatus);

            if ($gameStatus->isFinished()) {
                if (!$gameRecord->getIsRating()->getValue()) {
                    $trueSkillRequestData = $this->trueSkillRequestData($gameRecord->getPlayerMemories(), $winningTeam);
                    $trueSkillResponse = $this->trueSkillClient->calcSkill($trueSkillRequestData);

                    $players = $this->toPlayerFromCalcSkillResponse($players, $trueSkillResponse['teams']);
                }

                $gameRecord->changeWinningTeam($winningTeam);
            }

            $gameRecord->changeFinishedAt($currentDatetime);
            $gameRecord->changeGameStatus($gameStatus);

            // ゲームレコード更新
            $this->gameRecordRepository->update($gameRecord);

            // プレイヤー記録更新
            $this->updatePlayerMemories($gameRecord->getGameRecordId(), $players);

            // プレイヤー更新
            $this->playerService->updatePlayerFromRepository($players, $currentDatetime);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			throw $e;
		}

        // TODO: 今後ここは、Discord通知を非同期で行うようにコード修正する
        $this->sendPushNotification($gameRecord->getGameRecordId(), $isPushNotification);
    }

    /**
     * @param PlayerMemory[] $playerMemories
     * @param GameTeam|null $winningTeam
     * @return Player[]
     */
    private function pluckPlayer(array $playerMemories, ?GameTeam $winningTeam, GameStatus $gameStatus): array
    {
        $players = [];
        foreach ($playerMemories as $playerMemory) {
            $player = $playerMemory->getPlayer();

            if ($gameStatus->isFinished()) {
                if ($winningTeam->getValue() === $playerMemory->getTeam()->getValue()) {
                    $player = $this->playerService->changeWinnerPlayer($player);
                } else {
                    $player = $this->playerService->changeDefeatPlayer($player);
                }
            } else if ($gameStatus->isDraw()) {
                $player = $this->playerService->changeDrawPlayer($player);
            }

            $players[] = $player;
        }

        return $players;
    }

    /**
     * @param GameRecordId $gameRecordId
     * @param Player[] $players
     * @return void
     */
    private function updatePlayerMemories(GameRecordId $gameRecordId, array $players): void
    {
        foreach ($players as $player) {
            $this->playerMemoryRepository->update($gameRecordId, $player);
        }
    }

    /**
     * @param Player[] $players
     * @param $trueSkillRequestTeams
     * @return Player[]
     */
    private function toPlayerFromCalcSkillResponse(array $players, $trueSkillRequestTeams): array
    {
        $changedPlayers = [];
        foreach ($trueSkillRequestTeams as $trueSkillRequestTeam) {
            foreach ($trueSkillRequestTeam as $data) {
                foreach ($players as $player) {
                    if ($player->getPlayerId()->getValue() === $data->id) {
                        $player->changeMu(new Mu($data->mu));
                        $player->changeSigma(new Sigma($data->sigma));
                        $player->changeRate(new Rate($data->rating_exposure));
                    }

                    $changedPlayers[] = $player;
                }
            }
        }

        return $changedPlayers;
    }

    private function trueSkillRequestData(array $playerMemories, GameTeam $gameTeam): array
    {
        $data = [
            'teams' => [[],[]],
            'winning_team' =>  $gameTeam->getValue(),
        ];

        foreach ($playerMemories as $playerMemory) {
            $teamNo = $playerMemory->getTeam()->getValue() - 1;

            $player = $playerMemory->getPlayer();
            $data['teams'][$teamNo][] = [
                'id' => $player->getPlayerId()->getValue(),
                'name' => $player->getPlayerName()->getValue(),
                'mu' => $player->getMu()->getValue(),
                'sigma' => $player->getSigma()->getValue(),
            ];
        }

        return $data;
    }

    private function sendPushNotification(GameRecordId $gameRecordId, bool $pushNotification): void
    {
        if (!$pushNotification) {
            return;
        }

        $afterGameRecord = $this->gameRecordRepository->getById($gameRecordId);
        $this->discordRepository->endGameNotification($afterGameRecord);
    }
}