<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRecord;

class IsRating {
    private $value;

    public function __construct($value)
    {
        $this->value = (bool) $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}
