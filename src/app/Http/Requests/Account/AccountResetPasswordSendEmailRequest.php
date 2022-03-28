<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;

class AccountResetPasswordSendEmailRequest extends FormRequest
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
            'email' => [
                'required',
                'email:filter',
                'exists:users',
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attributeを入力してください。',
            'email.email' => '正しい:attribute形式で入力してください。',
            'email.exists' => '登録されている:attributeではありません。'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
        ];
    }
}
