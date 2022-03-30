<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Package\Domain\System\Entity\Paginator;

class PlayerModel extends Model
{
    protected $table = 'players';

    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopePaginator($query, ?Paginator $paginator = null)
    {
        if ($paginator) {
            $query->offset($paginator->getNextOffset())
            ->limit($paginator->getLimit()->getValue());
        }

        return $query;
    }

    // ユーザ情報
    public function user()
    {
        return $this->hasOne(UserModel::class, 'player_id', 'id');
    }
}
