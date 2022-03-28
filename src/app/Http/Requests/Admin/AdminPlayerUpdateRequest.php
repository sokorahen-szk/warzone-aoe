<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FailedValidationTrait;

class AdminPlayerUpdateRequest extends FormRequest
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
            'player_name'       => ['required', 'string'],
            'mu'                => ['required', 'numeric'],
            'sigma'             => ['required', 'numeric'],
            'rate'              => ['required', 'integer'],
            'enabled'           => ['required', 'boolean'],
        ];
    }
}
