<?php declare(strict_types=1);

namespace Package\Domain\Game\Service;

interface GameRecordServiceInterface {
	/**
	 * 選択されたプレイヤーIDから、試合中のユーザが存在するかどうか
	 *
	 * @param array $playerIds
	 * @return boolean
	 */
	public function isAlreadyMatchingGaming(array $playerIds): bool;
}
