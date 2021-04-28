<?php
namespace App\Traits;

trait ApiResponser {
  protected function validResponse($body, $code = 200)
  {
    return response()->json([
			'isSuccess'       => true,
			'data'            => $body
		], $code);
  }

  protected function failureResponse($message, $code = 500)
  {
    return response()->json([
			'isSuccess'       => false,
      'errorMessages'   => $message
		], $code);
  }
}