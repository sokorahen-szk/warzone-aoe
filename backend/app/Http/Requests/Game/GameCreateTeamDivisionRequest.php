<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;
use App\Rules\CheckArrayType;

class GameCreateTeamDivisionRequest extends FormRequest
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
        return [
            // プレイヤーID配列
            'player_ids'            => ['required', 'array', new CheckArrayType('integer')],

            // ゲームパッケージID
            'game_package_id'       => ['required', 'integer'],

            // ルールID
            'rule_id'               => ['required', 'integer'],

            // マップID
            'map_id'                => ['required', 'integer'],
        ];
    }
}
