<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use App\Http\Requests\Auth\LoginRequest;
use Package\Domain\User\ValueObject\Status;
use Exception;

class AuthController extends Controller
{

    const LOGIN_FAILED_ERROR = "ログインに失敗しました。";
    const ALREADY_LOGOUT_ERROR = "既にログアウトされています。";
    const USER_STATUS_WITHDRAWAL_ERROR = "退会ユーザのため、ログインできません。";
    const USER_STATUS_BANNED_ERROR = "運営者により、アカウントを停止されているため、ログインできません。";
    const LOGIN_PERMISSION_DENIED_ERROR = "ログイン権限がありません。";
    const SERVER_INTERNAL_ERROR = "サーバエラーが発生しました。";

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
                return response()->json($this->response(self::LOGIN_FAILED_ERROR, 401));
            }

            if (Auth::user()->status == Status::USER_STATUS_WITHDRAWAL) {
                auth()->logout();
                return response()->json($this->response(self::USER_STATUS_WITHDRAWAL_ERROR, 403));
            }
            if (Auth::user()->status == Status::USER_STATUS_BANNED) {
                auth()->logout();
                return response()->json($this->response(self::USER_STATUS_BANNED_ERROR, 403));
            }

            return response()->json($this->response($this->respondWithToken($token), 200));
        } catch (Exception $e) {
            return response()->json($this->response(self::SERVER_INTERNAL_ERROR, 500));
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
                $response = $this->response(null, self::ALREADY_LOGOUT_ERROR);
            }
        } catch (Exception $e) {
            return response()->json($this->response(self::SERVER_INTERNAL_ERROR, 500));
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

        if ($code === Response::HTTP_OK) {
            $response->body = $body;
        } else {
            $response->isSuccess = false;
            $response->errorMessages = $body;
        }

        return $response;
    }
}
