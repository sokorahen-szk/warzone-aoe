<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRecord;

class GameStatus
{
    private $value;

    const GAME_STATUS_MATCHING = 1;
    const GAME_STATUS_DRAW = 2;
    const GAME_STATUS_CANCELED = 3;
    const GAME_STATUS_FINISHED = 4;

    private $enums = [
    self::GAME_STATUS_MATCHING      => 'matching',
    self::GAME_STATUS_DRAW          => 'draw',
    self::GAME_STATUS_CANCELED      => 'canceled',
    self::GAME_STATUS_FINISHED      => 'finished',
  ];

    public function __construct($value)
    {
        $this->value = (int) $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getEnumName(): ?string
    {
        if (!array_key_exists($this->value, $this->enums)) {
            return null;
        }
        return $this->enums[$this->value];
    }
}
