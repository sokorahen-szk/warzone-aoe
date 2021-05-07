<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use \Package\Usecase\Game\GamePackage\GetList\GamePackageListServiceInterface;

class GamePackageController extends Controller
{
    use ApiResponser;

    public function list(GamePackageListServiceInterface $interactor)
    {
        $result = $interactor->handle();
        return $this->validResponse($result->getVars(), '取得しました。');
    }
}
