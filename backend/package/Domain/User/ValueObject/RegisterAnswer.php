<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class RegisterAnswer {

    private $tactics = [
        0 => '10戦以上',
        1 => '5戦以上',
        2 => 'なし',
    ];

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
