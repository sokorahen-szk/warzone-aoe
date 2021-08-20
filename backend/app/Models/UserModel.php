<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'role_id',
        'name',
        'steam_id',
        'twitter_id',
        'website_url',
        'avator_image',
        'email',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 登録済みのパッケージIDを文字列で返す
     * @return string
     */
    public function getGamePackageIdsAttribute(): string
    {
        return implode(',', $this->players->pluck('id')->toArray());
    }

    /**
     * リレーション
     */

     // プレイヤー
    public function players()
    {
        return $this->hasMany(PlayerModel::class, 'user_id');
    }

     // 権限情報
     public function role()
     {
         return $this->hasOne(RoleModel::class, 'id', 'role_id');
     }
}
