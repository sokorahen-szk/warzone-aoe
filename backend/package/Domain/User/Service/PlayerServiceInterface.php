<?php declare(strict_types=1);

namespace Package\Domain\User\Service;

use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\Entity\Player;

interface PlayerServiceInterface {
	/**
	 * 選択されたプレイヤーIDから、プレイヤーの情報を取得する
	 *
	 * @param array $playerIds
	 * @return array
	 */
	public function selectedPlayers(array $playerIds): array;

	/**
	 * 選択されたプレイヤーIDから、重複して選択されていないかどうか
	 *
	 * @param array $playerIds
	 * @return boolean
	 */
	public function isDuplicatePlayer(array $playerIds): bool;

	/**
	 * 勝利プレイヤー更新
	 *
	 * @param Player $player
	 * @return Player
	 */
	public function changeWinnerPlayer(Player $player): Player;

	/**
	 * 敗北プレイヤー更新
	 *
	 * @param Player $player
	 * @return Player
	 */
	public function changeDefeatPlayer(Player $player): Player;

	/**
	 * 引き分け 更新
	 *
	 * @param Player $player
	 * @return Player
	 */
	public function changeDrawPlayer(Player $player): Player;

    /**
     * @param Player[] $players
	 * Datetime $currentDatetime
     * @return void
     */
    public function updatePlayerFromRepository(array $players, Datetime $currentDatetime): void;
}
