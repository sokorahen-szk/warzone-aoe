<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Package\Usecase\Player\GetList\PlayerGetListServiceInterface;

class PlayerController extends Controller
{
    public function list(PlayerGetListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return response()->json($result->getVars());
    }
}
