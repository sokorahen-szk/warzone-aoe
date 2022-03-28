<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTokenModel extends Model
{
    use HasFactory;

    protected $table = 'user_tokens';

    protected $guarded = [];
}
