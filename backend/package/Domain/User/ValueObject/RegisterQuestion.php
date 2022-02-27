<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class RegisterQuestion {
    private $answer1;
    private $answer2;
    private $answer3;

    public function __construct(
        RegisterAnswer $answer1,
        RegisterAnswer $answer2,
        RegisterAnswer $answer3
    )
    {
        $this->answer1 = $answer1;
        $this->answer2 = $answer2;
        $this->answer3 = $answer3;
    }
}