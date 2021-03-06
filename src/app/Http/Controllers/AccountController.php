<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\AccountGameStatusUpdateRequest;
use App\Traits\ApiResponser;
use App\Http\Requests\Account\AccountRegistrationRequest;
use App\Http\Requests\Account\AccountUpdateAvatorRequest;
use App\Http\Requests\Account\AccountProfileEditRequest;
use App\Http\Requests\Account\AccountResetPasswordRequest;
use App\Http\Requests\Account\AccountResetPasswordSendEmailRequest;
use App\Http\Requests\Game\GameRaitingRequest;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordMuEnabled;
use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;
use Package\Usecase\Account\Register\AccountRegisterServiceInterface;
use Package\Usecase\Account\UpdateAvator\AccountUpdateAvatorCommand;
use Package\Usecase\Account\UpdateAvator\AccountUpdateAvatorServiceInterface;
use Package\Usecase\Account\DeleteAvator\AccountDeleteAvatorServiceInterface;
use Package\Usecase\Account\DeleteAvator\AccountDeleteAvatorCommand;
use Package\Usecase\Account\ChangeProfile\AccountChangeProfileServiceInterface;
use Package\Usecase\Account\ChangeProfile\AccountChangeProfileCommand;
use Package\Usecase\Account\Withdrawal\AccountWithdrawalServiceInterface;
use Package\Usecase\Account\Withdrawal\AccountWithdrawalCommand;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeServiceInterface;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeCommand;
use Package\Usecase\Account\Game\GetList\AccountGameListServiceInterface;
use Package\Usecase\Account\Game\StatusUpdate\AccountGameStatusUpdateServiceInterface;
use Package\Usecase\Account\Game\GetList\AccountGameListCommand;
use Package\Usecase\Account\Game\StatusUpdate\AccountGameStatusUpdateCommand;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordSendEmailCommand;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordSendEmailServiceInterface;

use Auth;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordCommand;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordServiceInterface;

class AccountController extends Controller
{
    use ApiResponser;

    /**
     * ???????????????????????????
     * @param AccountRegistrationRequest $request
     * @param AccountRegisterServiceInterface $interactor
     * @return json(...)
     */
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

        return $this->validResponse($result, '??????????????????????????????');
    }

    /**
     * ?????????????????????
     * @param AccountGetInfoServiceInterface $interactor
     * @return json(...)
     */
    public function show(AccountGetInfoServiceInterface $interactor)
    {
        $command = new AccountGetInfoCommand(Auth::user()->id);
        $result = $interactor->handle($command);

        return $this->validResponse($result->getVars(), '?????????????????????????????????????????????');
    }

    /**
     * ??????????????????
     * @param AccountUpdateAvatorRequest $request
     * @param AccountUpdateAvatorServiceInterface $interactor
     * @return json(...)
     */
    public function updateAvator(AccountUpdateAvatorRequest $request, AccountUpdateAvatorServiceInterface $interactor)
    {
        $command = new AccountUpdateAvatorCommand(
            Auth::user()->id,
            $request->file('file')
        );
        $result = $interactor->handle($command);

        return $this->validResponse($result, '?????????????????????????????????????????????');
    }

    /**
     * ??????????????????
     * @param AccountDeleteAvatorServiceInterface $interactor
     * @return json(...)
     */
    public function deleteAvator(AccountDeleteAvatorServiceInterface $interactor)
    {
        $command = new AccountDeleteAvatorCommand(
            Auth::user()->id
        );
        $result = $interactor->handle($command);

        return $this->validResponse($result, '????????????????????????????????????????????????');
    }

    /**
     * ????????????????????????
     * @param AccountProfileEditRequest $request
     * @param AccountChangeProfileServiceInterface $interactor
     * @return json(...)
     */
    public function changeProfile(AccountProfileEditRequest $request, AccountChangeProfileServiceInterface $interactor)
    {
        $command = new AccountChangeProfileCommand(
            Auth::user()->id,
            $request->user_name,
            $request->input('email', null),
            $request->input('password', null),
            $request->input('steam_id', null),
            $request->input('twitter_id', null),
            $request->input('web_site_url', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result, '??????????????????????????????????????????');
    }

    /**
     * ??????
     * @param AccountWithdrawalServiceInterface $interactor
     * @return json(...)
     */
    public function withdrawal(AccountWithdrawalServiceInterface $interactor)
    {
        $command = new AccountWithdrawalCommand(
            Auth::user()->id
        );
        $result = $interactor->handle($command);

        return $this->validResponse($result, '????????????????????????????????????');
    }

    /**
     * ????????????????????????
     *
     * @param GameRecordListByDateRangeServiceInterface $interactor
     * @param GameRaitingRequest $request
     * @return json(...)
     */
    public function raiting(GameRecordListByDateRangeServiceInterface $interactor, GameRaitingRequest $request)
    {
        $command = new GameRecordListByDateRangeCommand(
            Auth::user()->id,
            GameRecordMuEnabled::RAITING_MU_ENABLED,
            $request->begin_date,
            $request->input('end_date', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result, '????????????????????????????????????????????????');
    }

    public function gameList(AccountGameListServiceInterface $interactor)
    {
        $command = new AccountGameListCommand(
            Auth::user()->id
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result, '????????????????????????????????????????????????');
    }

    public function gameUpdate(AccountGameStatusUpdateServiceInterface $interactor, AccountGameStatusUpdateRequest $request, int $gameRecordId)
    {
        $command = new AccountGameStatusUpdateCommand(
            Auth::user()->id,
            $gameRecordId,
            $request->status,
            $request->input('winning_team', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result, '????????????????????????????????????????????????');
    }

    public function resetPasswordSendEmail(AccountResetPasswordSendEmailServiceInterface $interactor, AccountResetPasswordSendEmailRequest $request)
    {
        $command = new AccountResetPasswordSendEmailCommand(
            $request->email,
        );

        $interactor->handle($command);
        return $this->validResponse([], '????????????????????????????????????????????????????????????');
    }

    public function resetPassword(AccountResetPasswordServiceInterface $interactor, AccountResetPasswordRequest $request, string $token)
    {
        $command = new AccountResetPasswordCommand(
            $request->password,
            $token,
        );

        $interactor->handle($command);
        return $this->validResponse([], '???????????????????????????????????????????????????');
    }
}
