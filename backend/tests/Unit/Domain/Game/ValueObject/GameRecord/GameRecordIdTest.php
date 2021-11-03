<?php

namespace Tests\Unit\Domain\Game\ValueObject\GameRecord;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Tests\TestCase;

class GameRecordIdTest extends TestCase
{
    public function test_instance()
    {
        $instance = new GameRecordId(1);
        $this->assertInstanceOf(GameRecordId::class, $instance);
    }

    public function test_args_int()
    {
        $instance = new GameRecordId(1);
        $this->assertSame(1, $instance->getValue());
    }
}
