<?php declare(strict_types=1);

namespace Package\Domain\User\Service;

use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\PlayerId;

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
}