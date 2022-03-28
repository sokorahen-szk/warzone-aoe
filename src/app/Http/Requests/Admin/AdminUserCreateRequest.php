<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;

class AdminUserCreateRequest extends FormRequest
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
            'user_name'                 => ['required'],
            'player_name'               => ['required', 'string'],
            'role_id'                   => ['required', 'integer'],
            'password'                  => ['required', 'string', 'min:8'],
            'game_packages'             => ['sometimes', 'string'],
            'steam_id'                  => ['sometimes', 'string'],
        ];
    }
}
