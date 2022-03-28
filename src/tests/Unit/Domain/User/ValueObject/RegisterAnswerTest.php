<?php declare(strict_types=1);

namespace Tests\Unit\Domain\User\ValueObject;

use Package\Domain\User\ValueObject\RegisterAnswer;
use PHPUnit\Framework\TestCase;

class RegisterAnswerTest extends TestCase {
    public function test_arabia_game_experience_count()
    {
        $registerAnswer = new RegisterAnswer(
            '0',
            RegisterAnswer::ARABIA_GAME_EXPERIENCE_COUNT
        );
        $this->assertEquals([
            '10戦以上'
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            '2',
            RegisterAnswer::ARABIA_GAME_EXPERIENCE_COUNT
        );
        $this->assertEquals([
            'なし'
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            '0,1,2',
            RegisterAnswer::ARABIA_GAME_EXPERIENCE_COUNT
        );
        $this->assertEquals([
            '10戦以上',
            '5戦以上',
            'なし',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            null,
            RegisterAnswer::ARABIA_GAME_EXPERIENCE_COUNT
        );
        $this->assertCount(0, $registerAnswer->getList());
    }

    public function test_tactics()
    {
        $registerAnswer = new RegisterAnswer(
            '1',
            RegisterAnswer::TACTICS
        );
        $this->assertEquals([
            '前衛 22～23人弓',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            '7',
            RegisterAnswer::TACTICS
        );
        $this->assertEquals([
            '後衛 即ユニーク',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            '1,2,3,4,5,6,7',
            RegisterAnswer::TACTICS
        );
        $this->assertEquals([
            '前衛 22～23人弓',
            '前衛 軍平',
            '前衛 TR',
            '後衛 22人斥候',
            '後衛 即城騎士',
            '後衛 直',
            '後衛 即ユニーク',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            null,
            RegisterAnswer::TACTICS
        );
        $this->assertCount(0, $registerAnswer->getList());
    }

    public function test_community_joined()
    {
        $registerAnswer = new RegisterAnswer(
            '1',
            RegisterAnswer::COMMUNITY_JOINED
        );
        $this->assertEquals([
            'AOCHD.JP',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            '8',
            RegisterAnswer::COMMUNITY_JOINED
        );
        $this->assertEquals([
            'IRSJ',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            '1,2,3,4,5,6,7,8',
            RegisterAnswer::COMMUNITY_JOINED
        );
        $this->assertEquals([
            'AOCHD.JP',
            'ニコ生AOC',
            'たまひよ、こっこ',
            'aok予備校',
            'ブラシス',
            'SIREN',
            'JGZ',
            'IRSJ',
        ], $registerAnswer->getList());

        $registerAnswer = new RegisterAnswer(
            null,
            RegisterAnswer::COMMUNITY_JOINED
        );
        $this->assertCount(0, $registerAnswer->getList());
    }
}