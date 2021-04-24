<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
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

            // 退会、アカウント停止
            if (Auth::user()->status == 'withdrawal' || Auth::user()->status == 'banned') {
                auth()->logout();
                return response()->json($this->response(null, 403));
            }

            $response = $this->response($this->respondWithToken($token), 200);
            return response()->json($response);
        } catch (\Exception $e) {
            // ロギング...
            return response()->json($this->response(null, 500));
        }
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function logout()
    {
        $response = $this->response(null, 200);

        try {
            if (Auth::check()) {
                auth()->logout();
            } else {
                $response = $this->response(null, 406);
            }
        } catch (\Exception $e) {
            // ロギング...
            return response()->json($this->response(null, 500));
        }

        return response()->json($response);
    }

    protected function respondWithToken($token): array
    {
        return [
            'token'         => $token,
            'expires_in'    => auth()->factory()->getTTL() * 60,
        ];
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
                $response->errorMessages[] = $body ?: 'ログインに失敗しました。';
                break;
            case Response::HTTP_NOT_ACCEPTABLE:
                $response->isSuccess = false;
                $response->errorMessages[] = $body ?: '既にログアウトされています。';
                break;
            case Response::HTTP_FORBIDDEN:
                $response->isSuccess = false;
                $response->errorMessages[] = $body ?: 'ログイン権限がありません。';
                break;
            case Response::HTTP_INTERNAL_SERVER_ERROR:
            default:
                $response->isSuccess = false;
                $response->errorMessages[] = $body ?: 'サーバエラーが発生しました。';
                break;
        }

        return $response;
    }
}
