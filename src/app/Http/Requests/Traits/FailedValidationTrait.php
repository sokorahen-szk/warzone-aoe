<?php


namespace App\Http\Requests\Traits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

trait FailedValidationTrait
{
    /**
     * @return  \Illuminate\Contracts\Validation\Validator  $validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors()->messages())->flatten()->toArray();

        $response = [
            'isSuccess'     => false,
            'errorMessages'  => $errors,
        ];

        throw new HttpResponseException(
            response()->json($response, Response::HTTP_OK)
        );
    }
}