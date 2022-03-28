<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRecordTokenModel extends Model
{
    protected $table = 'game_record_tokens';

    public $timestamps = false;

    protected $guarded = [];
}
