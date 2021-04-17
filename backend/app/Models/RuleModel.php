<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleModel extends Model
{
    protected $table = 'rules';

    public $timestamps = false;

    protected $guarded = [];
}
