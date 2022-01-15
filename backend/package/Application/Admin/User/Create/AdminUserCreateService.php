<?php declare(strict_types=1);

namespace Package\Application\Admin\User\Create;

use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Usecase\Admin\User\Create\AdminUserCreateCommand;
use Package\Usecase\Admin\User\Create\AdminUserCreateServiceInterface;
use Package\Domain\User\Exceptions\CanNotRegisterUserException;
use Package\Domain\User\Service\UserServiceInterface;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Player\Enabled;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

use DB;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\Sigma;

class AdminUserCreateService implements AdminUserCreateServiceInterface {

    private $userRepository;
    private $userService;
    private $playerRepository;
    private $trueSkillClient;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService,
        PlayerRepositoryInterface $playerRepository,
        TrueSkillClient $trueSkillClient
    )
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->playerRepository = $playerRepository;
        $this->trueSkillClient = $trueSkillClient;
    }

    public function handle(AdminUserCreateCommand $command): void
    {
        $registerPlayer = new Player([
            'playerName'    => new PlayerName($command->playerName),
            'gamePackages'  => new GamePackages($command->gamePackages),
        ]);

        try {
            DB::beginTransaction();

            $playerId = $this->playerRepository->register($registerPlayer);

            $user = new User([
                'playerId'    => $playerId,
                'roleId'      => new RoleId($command->roleId),
                'name'        => new Name($command->userName),
                'email'       => new Email(null),
                'password'    => new Password($command->password),
            ]);

            if ($this->userService->exists($user)) {
                throw new CanNotRegisterUserException("ユーザ名が既に存在しています。");
            }

            $this->userRepository->register($user);

            $player = $this->playerRepository->getById($playerId);

            $trueSkillDefaultSkillResponse = $this->trueSkillClient->defaultSkill();
            $player->changeMu(new Mu($trueSkillDefaultSkillResponse['mu']));
            $player->changeSigma(new Sigma($trueSkillDefaultSkillResponse['sigma']));
            $player->changeRate(new Rate($trueSkillDefaultSkillResponse['rating_exposure']));

            $player->changeEnabled(new Enabled(true));

            $this->playerRepository->updateEnabled($player);
            $this->playerRepository->update($player);

            DB::commit();
        } catch (Exception $e) {
          DB::rollback();
          throw $e;
        }
    }
}