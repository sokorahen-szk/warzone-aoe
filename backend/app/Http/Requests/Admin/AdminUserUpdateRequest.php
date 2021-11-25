<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;

class AdminUserUpdateRequest extends FormRequest
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
            'email'                     => ['sometimes', 'email'],
            'password'                  => [
                                                'sometimes',
                                                'string',
                                                'min:8',
                                        ],
            'steam_id'                  => ['sometimes', 'string'],
            'twitter_id'                => ['sometimes', 'string'],
            'web_site_url'              => ['sometimes', 'url', 'active_url'],

            'status'                    => ['sometimes', 'integer'],
        ];
    }
}
