<?php declare(strict_types=1);

namespace Package\Application\Admin\RegisterRequest\Update;

use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateCommand;
use Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateServiceInterface;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\Entity\RegisterRequest;
use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Domain\User\ValueObject\Register\Remarks;
use Package\Domain\User\ValueObject\Player\Enabled;

class AdminRegisterRequestUpdateService implements AdminRegisterRequestUpdateServiceInterface {
  private $registerRequestRepository;
  private $playerRepository;

  public function __construct(
    RegisterRequestRepositoryInterface $registerRequestRepository,
    PlayerRepositoryInterface $playerRepository
  )
  {
    $this->registerRequestRepository = $registerRequestRepository;
    $this->playerRepository = $playerRepository;
  }

  public function handle(AdminRegisterRequestUpdateCommand $command): void
  {
    $status = new RegisterStatus($command->status);

    $registerRequest = $this->registerRequestRepository->get(new RegisterId($command->registerRequestId));
    $registerRequest->changeUserId(new UserId($command->userId));
    $registerRequest->changeRegisterStatus($status);
    $registerRequest->changeRemarks(new Remarks($command->remarks));

    $this->registerRequestRepository->update($registerRequest);

    $player = $registerRequest->getPlayer();
    $player->changeEnabled(new Enabled($status->isValid()));

    $this->playerRepository->updateEnabled($player);
  }
}