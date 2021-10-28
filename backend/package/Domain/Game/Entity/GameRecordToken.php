<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Domain\System\ValueObject\Datetime;

class GameRecordToken extends Resource
{
	protected $gameRecordId;
    protected $gameToken;
    protected $expiresAt;

	public function __construct($data)
	{
	  parent::__construct($data);
	}

    public function getGameRecordId(): ?GameRecordId
    {
        return $this->gameRecordId;
    }

    public function getGameToken(): ?GameToken
    {
        return $this->gameToken;
    }

    public function getExpiresAt(): ?Datetime
    {
        return $this->expiresAt;
    }
}