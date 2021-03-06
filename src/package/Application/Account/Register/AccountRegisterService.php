<?php declare(strict_types=1);

namespace Package\Application\Account\Register;

use Package\Usecase\Account\Register\AccountRegisterServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Service\UserServiceInterface;

use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\RegisterRequest;

use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Password;

use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\GamePackages;

use Package\Domain\User\Exceptions\CanNotRegisterUserException;

use DB;
use Package\Domain\Game\Repository\GamePackageRepositoryInterface;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\RegisterAnswer;
use Package\Domain\User\ValueObject\RegisterQuestion;
use Package\Infrastructure\Discord\DiscordRepositoryInterface;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

class AccountRegisterService implements AccountRegisterServiceInterface {
  private $userRepository;
  private $playerRepository;
  private $registerRequestRepository;
  private $userService;
  private $discordRepository;
  private $gamePackageRepository;
  private $trueSkillClient;

  const DEFAULT_ROLE_ID_NUMBER = 4;

  public function __construct(
    UserRepositoryInterface $userRepository,
    PlayerRepositoryInterface $playerRepository,
    RegisterRequestRepositoryInterface $registerRequestRepository,
    UserServiceInterface $userService,
    DiscordRepositoryInterface $discordRepository,
    GamePackageRepositoryInterface $gamePackageRepository,
    TrueSkillClient $trueSkillClient
  )
  {
    $this->userRepository = $userRepository;
    $this->playerRepository = $playerRepository;
    $this->registerRequestRepository = $registerRequestRepository;
    $this->userService = $userService;
    $this->discordRepository = $discordRepository;
    $this->gamePackageRepository = $gamePackageRepository;
    $this->trueSkillClient = $trueSkillClient;
  }

  public function handle(AccountRegisterCommand $command)
  {
    $player = new Player([
      'playerName'    => new PlayerName($command->playerName),
      'gamePackages'  => new GamePackages($command->gamePackages),
    ]);

    try {
      DB::beginTransaction();

      $registerQuestion = new RegisterQuestion(
        new RegisterAnswer($command->answer1, RegisterAnswer::ARABIA_GAME_EXPERIENCE_COUNT),
        new RegisterAnswer($command->answers2, RegisterAnswer::TACTICS),
        new RegisterAnswer($command->answers3, RegisterAnswer::COMMUNITY_JOINED)
      );

      $playerId = $this->playerRepository->register($player);

      $registerUser = new User([
        'playerId'    => $playerId,
        'roleId'      => new RoleId(self::DEFAULT_ROLE_ID_NUMBER),
        'name'        => new Name($command->userName),
        'email'       => new Email($command->email),
        'password'    => new Password($command->password),
      ]);

      if ($this->userService->exists($registerUser)) {
        throw new CanNotRegisterUserException("?????????????????????????????????????????????");
      }

      $userId = $this->userRepository->register($registerUser);

      $this->registerRequestRepository->register(new RegisterRequest([
        'playerId'      => $playerId,
      ]));

      $this->changePlayerDefaultSkill($playerId);

      $user = $this->userRepository->findUserById($userId);
      $gamePackages = $this->gamePackageRepository->list();
      $registerDatetime = new Datetime(now());
      $this->discordRepository->registrationUserNotification($registerDatetime, $user, $registerQuestion, $gamePackages);

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  private function changePlayerDefaultSkill(PlayerId $playerId): void
  {
    $player = $this->playerRepository->getById($playerId);
    $trueSkillDefaultSkillResponse = $this->trueSkillClient->defaultSkill();

    $player->changeMu(new Mu($trueSkillDefaultSkillResponse['mu']));
    $player->changeSigma(new Sigma($trueSkillDefaultSkillResponse['sigma']));
    $player->changeRate(new Rate($trueSkillDefaultSkillResponse['rating_exposure']));

    $this->playerRepository->update($player);
  }
}