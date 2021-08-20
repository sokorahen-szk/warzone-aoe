<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PlayerModel;

class RegisterRequestModel extends Model
{
    use HasFactory;

    protected $table = 'register_requests';

    public $timestamps = false;

    protected $guarded = [];

    // ユーザ情報
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
