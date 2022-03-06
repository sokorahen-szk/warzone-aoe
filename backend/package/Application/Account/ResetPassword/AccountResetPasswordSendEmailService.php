<?php declare(strict_types=1);

namespace Package\Application\Account\ResetPassword;

use App\Mail\ResetPasswordEmail;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordSendEmailServiceInterface;
use Package\Domain\User\ValueObject\Email;
use Package\Usecase\Account\ResetPassword\AccountResetPasswordSendEmailCommand;

use Exception;
use DB;
use Mail;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Token;
use Package\Domain\User\Repository\UserTokenRepositoryInterface;

class AccountResetPasswordSendEmailService implements AccountResetPasswordSendEmailServiceInterface {

  private $userRepository;
  private $userTokenRepository;

  const DEFAULT_TOKEN_EXPIRE_HOURS = 1;

  public function __construct(
    UserRepositoryInterface $userRepository,
    UserTokenRepositoryInterface $userTokenRepository
  )
  {
    $this->userRepository = $userRepository;
    $this->userTokenRepository = $userTokenRepository;
  }

  public function handle(AccountResetPasswordSendEmailCommand $command)
  {
    $email = new Email($command->email);
    $user = $this->userRepository->findByEmail($email);

    if (!$user) {
      throw new Exception('登録されているメールアドレスが存在しません。');
    }

    $expireAt = new Datetime(now());
    $expireAt->addHours(self::DEFAULT_TOKEN_EXPIRE_HOURS);

    $token = new Token($expireAt->getDatetime());

    //try {
    //  DB::beginTransaction();
      $this->userTokenRepository->save($user->getId(), $email, $token, $expireAt);

      Mail::send(new ResetPasswordEmail($token->getValue(), $email->getValue()));

    //  DB::commit();
    //} catch (Exception $e) {
    //  DB::rollback();
    //}
  }
}