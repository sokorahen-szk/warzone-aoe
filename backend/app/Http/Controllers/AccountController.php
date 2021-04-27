<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRegistrationRequest;
use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;

class AccountController extends Controller
{
    public function registration(AccountRegistrationRequest $request)
    {
        return null;
    }
    public function show(AccountGetInfoServiceInterface $interactor)
    {
        $command = new AccountGetInfoCommand(\Auth::user()->id);
        $result = $interactor->handle($command);

        return response()->json($result->getVars());
    }
}
