<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

use Carbon\Carbon;

class Date
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value ? new Carbon($value) : Carbon::now();
    }

    public function getValue(): Carbon
    {
        return $this->value;
    }

    public function getDateFormatYYYYMMDD(): string
    {
        return $this->value->format('Y-m-d');
    }

    public function getDateFormatYYYYMMDDForBegin(): string
    {
        return $this->value->format('Y-m-d 00:00:00');
    }

    public function getDateFormatYYYYMMDDForEnd(): string
    {
        return $this->value->format('Y-m-d 23:59:59');
    }
}
