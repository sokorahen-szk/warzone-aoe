<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

use Carbon\Carbon;

class Date
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value ? new Carbon($value) : null;
    }

    public function getValue(): ?Carbon
    {
        return $this->value;
    }

    public function getDateFormatYYYYMMDD(): ?string
    {
        if (!$this->value) {
            return null;
        }
        return $this->value->format('Y-m-d');
    }

    public function getDateFormatYYYYMMDDForBegin(): ?string
    {
        if (!$this->value) {
            return null;
        }
        return $this->value->format('Y-m-d 00:00:00');
    }

    public function getDateFormatYYYYMMDDForEnd(): ?string
    {
        if (!$this->value) {
            return null;
        }
        return $this->value->format('Y-m-d 23:59:59');
    }
}
