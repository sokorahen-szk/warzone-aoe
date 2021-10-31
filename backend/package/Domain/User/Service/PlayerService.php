<?php declare(strict_types=1);

namespace Package\Domain\User\Service;

use Package\Domain\User\Entity\Player;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\Defeat;
use Package\Domain\User\ValueObject\Player\Games;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\Streak;
use Package\Domain\User\ValueObject\Player\Win;

class PlayerService implements PlayerServiceInterface {
    private $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

	/**
	 * 選択されたプレイヤーIDから、重複して選択されていないかどうか
	 *
	 * @param array $playerIds
	 * @return boolean
	 */
	public function isDuplicatePlayer(array $playerIds): bool
	{
		for ($i = 0; $i < count($playerIds); $i++) {
			for ($j = $i; $j < count($playerIds); $j++) {
				if ($i === $j) continue;
				if ($playerIds[$i] === $playerIds[$j]) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * 選択されたプレイヤーIDから、プレイヤーの情報を取得する
	 *
	 * @param array $playerIds
	 * @return array
	 */
	public function selectedPlayers(array $playerIds): array
	{
		$resource = [];
		foreach ($playerIds as $id) {
			$player = $this->playerRepository->getById(new PlayerId($id));
			$resource[] = [
				'id'	=> $player->getPlayerId()->getValue(),
				'name'	=> $player->getPlayerName()->getValue(),
				'mu'	=> $player->getMu()->getValue(),
				'sigma'	=> $player->getSigma()->getValue(),
			];
		}

		return $resource;
	}

	/**
	 * 勝利プレイヤー更新
	 *
	 * @param Player $player
	 * @return Player
	 */
	public function changeWinnerPlayer(Player $player): Player
	{
		$win = new Win($player->getWin()->getValue());
		$games = new Games($player->getGames()->getValue());

		$win->increment();
		$games->increment();

		$player->changeWin($win);
		$player->changeGames($games);

		$player = $this->updateStreak($player, true);

		return $player;
	}

	/**
	 * 敗北プレイヤー更新
	 *
	 * @param Player $player
	 * @return Player
	 */
	public function changeDefeatPlayer(Player $player): Player
	{
		$defeat = new Defeat($player->getDefeat()->getValue());
		$games = new Games($player->getGames()->getValue());

		$defeat->increment();
		$games->increment();

		$player->changeDefeat($defeat);
		$player->changeGames($games);

		$player = $this->updateStreak($player, false);

		return $player;
	}

	/**
	 * 連勝・連敗を更新する
	 *
	 * @param Player $player
	 * @param boolean $winner
	 * @return Player
	 */
	private function updateStreak(Player $player, bool $winner): Player
	{
		$streak = new Streak($player->getStreak()->getValue());
		if ($winner) {
			if ($streak->getValue() < 0) {
				$streak->clear();
			}

			$streak->increment();
		} else {
			if ($streak->getValue() > 0) {
				$streak->clear();
			}

			$streak->decrement();
		}

		$player->changeStreak($streak);
		return $player;
	}
}