<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function username()
    {
        return 'name';
    }

    public function login(LoginRequest $request)
    {
        try {
            $auth =[
                'name'      => $request->name,
                'password'  => $request->password,
            ];

            if (!$token = Auth::guard('api')->attempt($auth)) {
                return response()->json($this->response(null, 401));
            }

            $response = $this->response($this->respondWithToken($token), 200);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json($this->response(null, 500));
        }
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    private function response($body, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = (object) [
            'isSuccess'     => true,
            'errorMessages' => [],
            'body'          => null,
        ];

        switch ($code) {
            case Response::HTTP_OK:
                $response->body = $body;
                break;
            case Response::HTTP_UNAUTHORIZED:
                $response->isSuccess = false;
                $response->errorMessages = 'ログインに失敗しました。';
                break;
            case Response::HTTP_INTERNAL_SERVER_ERROR:
            default:
                $response->isSuccess = false;
                $response->errorMessages = 'サーバエラーが発生しました。';
                break;
        }

        return $response;
    }

    public function logout()
    {
        $response = $this->response(null, 200);

        try {
            if (Auth::check()) {
                auth()->logout();
            }
        } catch (\Exception $e) {
            return response()->json($this->response(null, 500));
        }

        return response()->json($response);
    }

    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}
