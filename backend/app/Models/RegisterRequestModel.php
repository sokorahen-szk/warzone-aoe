<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterRequestModel extends Model
{
    use HasFactory;

    protected $table = 'register_requests';

    public $timestamps = false;

    protected $guarded = [];
}