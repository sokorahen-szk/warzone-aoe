<?php

namespace Package\Usecase\Player\GetHistory;

use Package\Usecase\Data;

/**
 * Data Transfer Object
 */
class PlayerGetHistoryData extends Data
{
	public $playerHistories;

	public function __construct($sources)
	{
		$this->playerHistories = $sources;
	}
}