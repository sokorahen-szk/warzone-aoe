<?php declare(strict_types=1);

namespace Package\Application\Account\ResetPassword;

use App\Mail\ResetPasswordCompleted;
use Package\Domain\User\Repository\UserRepositoryInterface;

use Exception;
use DB;
use Mail;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Token;
use Package\Domain\User\Repository\UserTokenRepositoryInterface;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\UserId;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordServiceInterface;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordCommand;

class AccountResetPasswordService implements AccountResetPasswordServiceInterface {

    private $userTokenRepository;
    private $userRepository;

    public function __construct(
        UserTokenRepositoryInterface $userTokenRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->userTokenRepository = $userTokenRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param AccountResetPasswordCommand $command
     */
    public function handle(AccountResetPasswordCommand $command)
    {
        $token = new Token($command->token);

        $userToken = $this->userTokenRepository->getByToken($token);

        $currentDatetime = new Datetime(now());
        if (!$userToken->isValidExpires($currentDatetime)) {
            throw new Exception('パスワード再発行の有効期限が切れています。');
        }

        $user = $this->userRepository->findUserById($userToken->getUserId());

        try {
            DB::beginTransaction();

            $user->changePassword(new Password($command->password));

            Mail::send(new ResetPasswordCompleted($user->getEmail()->getValue()));

            $this->userRepository->changeProfile($user);
            $this->userTokenRepository->delete($userToken->getUserTokenId());

            DB::commit();
        } catch (Exception $e) {
          DB::rollback();
        }
    }
}