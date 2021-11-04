<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GamePackageModel extends Model
{
    use HasFactory;

    protected $table = 'game_packages';

    public $timestamps = false;

    protected $guarded = [];
}
