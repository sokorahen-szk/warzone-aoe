<?php declare(strict_types=1);

namespace Package\Application\Admin\RegisterRequest\GetList;

use Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestData;
use Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestGetListServiceInterface;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;

class AdminRegisterRequestGetListService implements AdminRegisterRequestGetListServiceInterface {
  private $registerRequestRepository;

  public function __construct(RegisterRequestRepositoryInterface $registerRequestRepository)
  {
    $this->registerRequestRepository = $registerRequestRepository;
  }

  public function handle(): ?AdminRegisterRequestData
  {
    $registerRequests = $this->registerRequestRepository->listAtWaiting();
    if (is_null($registerRequests)) {
      return null;
    }

    return new AdminRegisterRequestData($registerRequests);
  }
}