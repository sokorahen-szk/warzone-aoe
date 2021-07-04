<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class GameHistoryListRequest extends FormRequest
{
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
            'page'              => ['integer'],
            'offset'            => ['integer'],
            'begin_date'        => ['sometimes', 'date'],
            'end_date'          => ['sometimes', 'date'],
        ];
    }
}
