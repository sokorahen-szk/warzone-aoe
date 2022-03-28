<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;

class AccountResetPasswordRequest extends FormRequest
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
            'password'                  => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'password_confirmation'     => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ':attributeを入力してください',
            'password.confirmed' => ':attributeが:attribute再入力と一致していません',
            'password_confirmation.required' => ':attributeを入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード再設定',
        ];
    }
}
