<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;

class AccountController extends Controller
{
    public function show(AccountGetInfoServiceInterface $interactor)
    {
        $command = new AccountGetInfoCommand(\Auth::user()->id);
        $result = $interactor->handle($command);

        return response()->json($result->getVars());
    }
}
