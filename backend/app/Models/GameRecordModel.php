<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRecordModel extends Model
{
    use HasFactory;

    protected $table = 'game_records';

    public $timestamps = false;

    protected $guarded = [];
}
