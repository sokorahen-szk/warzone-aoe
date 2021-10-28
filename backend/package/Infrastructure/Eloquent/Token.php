<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent;
use Carbon\Carbon;

class Token {
    public static function generate(): string
    {
       return Carbon::now()->format('YmdHis') . str_random(36);
    }
}