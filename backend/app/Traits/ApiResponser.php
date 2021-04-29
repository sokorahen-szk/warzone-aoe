<?php
namespace App\Traits;

trait ApiResponser {
  protected function validResponse($body, $messages, $code = 200)
  {
    return response()->json([
			'isSuccess'       => true,
      'messages'        => $messages,
			'body'            => $body,
		], $code);
  }

  protected function failureResponse($messages, $code = 500)
  {
    return response()->json([
			'isSuccess'       => false,
      'errorMessages'   => $messages,
		], $code);
  }
}