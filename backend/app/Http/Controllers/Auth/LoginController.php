<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            if (Auth::guard('api')->attempt($auth)) {
                echo "A";
            } else {
                echo "Aa";
            }

        } catch (\Exception $e) {
            //
        }
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
