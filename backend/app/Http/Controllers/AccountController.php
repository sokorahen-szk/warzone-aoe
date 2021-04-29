<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRegistrationRequest;
use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;
use Package\Usecase\Account\Register\AccountRegisterServiceInterface;
use Exception;

class AccountController extends Controller
{
    use ApiResponser;

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

        try {
            \DB::beginTransaction();
            $result = $interactor->handle($command);
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
            throw $e;
        }

        return $this->validResponse($result, '登録が完了しました。');
    }

    public function show(AccountGetInfoServiceInterface $interactor)
    {
        $command = new AccountGetInfoCommand(\Auth::user()->id);
        $result = $interactor->handle($command);

        return response()->json($result->getVars());
    }
}
