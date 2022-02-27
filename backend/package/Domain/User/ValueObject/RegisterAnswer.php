<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class RegisterAnswer {

    const ARABIA_GAME_EXPERIENCE_COUNT = 1;
    const TACTICS = 2;
    const COMMUNITY_JOINED = 3;

    private $arabiaGameExperienceCountList = [
        0 => '10戦以上',
        1 => '5戦以上',
        2 => 'なし',
    ];

    private $tacticsList = [
        1 => '前衛 22～23人弓',
        2 => '前衛 軍平',
        3 => '前衛 TR',
        4 => '後衛 22人斥候',
        5 => '後衛 即城騎士',
        6 => '後衛 直',
        7 => '後衛 即ユニーク',
    ];

    private $communityJoinedList = [
        1 => 'AOCHD.JP',
        2 => 'ニコ生AOC',
        3 => 'たまひよ、こっこ',
        4 => 'aok予備校',
        5 => 'ブラシス',
        6 => 'SIREN',
        7 => 'JGZ',
        8 => 'IRSJ',
    ];

    private $answerMaps;

    private $kind;

    public function __construct($value, $kind)
    {
        $this->answerMaps = [
            self::ARABIA_GAME_EXPERIENCE_COUNT => $this->arabiaGameExperienceCountList,
            self::TACTICS => $this->tacticsList,
            self::COMMUNITY_JOINED => $this->communityJoinedList,
        ];

        $this->kind = $kind;
        $this->value = $value;
    }

    public function getList()
    {
        if (is_null($this->value) || strlen($this->value) < 1) return [];

        if (strpos($this->value, ',') === false) {
            $list = [$this->value];
        } else {
            $list = explode(',', $this->value);
        }

        return $this->mapping($list);
    }

    private function mapping(array $list)
    {
        foreach ($list as $selectedId) {
            $answers = $this->answerMaps[$this->kind];
            if (count($answers) < 1) {
                continue;
            }

            $value = $answers[(int)$selectedId];
            if ($value) {
                $selectedMappingValues[] = $value;
            }
        }

        return $selectedMappingValues;
    }
}
