<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRegistrationRequest;
use App\Http\Requests\Account\AccountUpdateAvatorRequest;
use App\Http\Requests\Account\AccountProfileEditRequest;

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
use Exception;

class AccountController extends Controller
{
    use ApiResponser;

    /**
     * アカウント新規作成
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

    /**
     * アカウント詳細
     * @param AccountGetInfoServiceInterface $interactor
     * @return json(...)
     */
    public function show(AccountGetInfoServiceInterface $interactor)
    {
        $command = new AccountGetInfoCommand(\Auth::user()->id);
        $result = $interactor->handle($command);

        return $this->validResponse($result->getVars(), 'アカウント詳細を取得しました。');
    }

    /**
     * アバター更新
     * @param AccountUpdateAvatorRequest $request
     * @param AccountUpdateAvatorServiceInterface $interactor
     * @return json(...)
     */
    public function updateAvator(AccountUpdateAvatorRequest $request, AccountUpdateAvatorServiceInterface $interactor)
    {
        $command = new AccountUpdateAvatorCommand(
            \Auth::user()->id,
            $request->file('file')
        );
        $result = $interactor->handle($command);

        return $this->validResponse($result, 'プロフィール画像更新しました。');
    }

    /**
     * アバター削除
     * @param AccountDeleteAvatorServiceInterface $interactor
     * @return json(...)
     */
    public function deleteAvator(AccountDeleteAvatorServiceInterface $interactor)
    {
        $command = new AccountDeleteAvatorCommand(
            \Auth::user()->id
        );
        $result = $interactor->handle($command);

        return $this->validResponse($result, 'プロフィール画像を削除しました。');
    }

    /**
     * プロフィール更新
     * @param AccountProfileEditRequest $request
     * @param AccountChangeProfileServiceInterface $interactor
     * @return json(...)
     */
    public function changeProfile(AccountProfileEditRequest $request, AccountChangeProfileServiceInterface $interactor)
    {
        $command = new AccountChangeProfileCommand(
            \Auth::user()->id,
            $request->user_name,
            $request->input('email', null),
            $request->input('password', null),
            $request->input('steam_id', null),
            $request->input('twitter_id', null),
            $request->input('web_site_url', null)
        );

        $result = $interactor->handle($command);

        return $this->validResponse($result, 'プロフィールを更新しました。');
    }

    /**
     * 退会
     * @param AccountWithdrawalServiceInterface $interactor
     * @return json(...)
     */
    public function withdrawal(AccountWithdrawalServiceInterface $interactor)
    {
        $command = new AccountWithdrawalCommand(
            \Auth::user()->id
        );
        $result = $interactor->handle($command);

        return $this->validResponse($result, '退会処理が完了しました。');
    }
}
