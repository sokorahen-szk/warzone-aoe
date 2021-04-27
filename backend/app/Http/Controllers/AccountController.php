<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRegistrationRequest;
use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;
use Package\Usecase\Account\Register\AccountRegisterServiceInterface;

class AccountController extends Controller
{
    public function registration(AccountRegistrationRequest $request, AccountRegisterServiceInterface $interactor)
    {
        $command = new AccountRegisterCommand(
            $request->user_name,
            $request->player_name,
            $request->password,
            $request->input('email', null),
            $request->input('game_package', null),
            $request->input('answer1', null),
            $request->input('answers2', null),
            $request->input('answers3', null)
        );
        $result = $interactor->handle($command);

        return response()->json($result);
    }

    public function show(AccountGetInfoServiceInterface $interactor)
    {
        $command = new AccountGetInfoCommand(\Auth::user()->id);
        $result = $interactor->handle($command);

        return response()->json($result->getVars());
    }
}
