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

    public function getAnswer1(): RegisterAnswer
    {
        return $this->answer1;
    }

    public function getAnswer2(): RegisterAnswer
    {
        return $this->answer2;
    }

    public function getAnswer3(): RegisterAnswer
    {
        return $this->answer3;
    }
}