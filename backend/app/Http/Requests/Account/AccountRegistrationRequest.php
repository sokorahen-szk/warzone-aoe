<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;
use Illuminate\Validation\Rule;

class AccountRegistrationRequest extends FormRequest
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
            'user_name'                 => ['required', 'string'],
            'player_name'               => ['required', 'string'],
            'password'                  => [
                                                'required',
                                                'string',
                                                'min:8',
                                                'required_with:password_confirmation',
                                                'same:password_confirmation'
                                        ],
            'password_confirmation'     => ['required', 'string'],
            'email'                     => ['sometimes', 'email'],
            'game_package_ids'          => ['required', 'string'],
            'answer1'                   => ['sometimes', 'integer'],
            'answers2'                  => ['sometimes', 'string'],
            'answers3'                  => ['sometimes', 'string'],
        ];
    }
}
