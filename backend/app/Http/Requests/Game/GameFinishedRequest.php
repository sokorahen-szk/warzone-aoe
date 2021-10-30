<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;

class GameFinishedRequest extends FormRequest
{
    use FailedValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $excludeUnlessRuleByTeam = sprintf('exclude_unless:status,%d', GameStatus::GAME_STATUS_FINISHED);
        return [
            // ゲームレコードトークン
            'token'         => ['required', 'string'],

            // ゲーム終了、引き分け or 取り消し
            'status'        => ['required', 'integer'],

            // ゲーム終了の時に勝利チームを指定する必要がある
            // 勝利チーム
            'winning_team'  => [$excludeUnlessRuleByTeam, 'required', 'integer'],
        ];
    }
}
