<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\Entity\RegisterRequest;

interface RegisterRequestRepositoryInterface {
  /**
   * 登録リクエスト作成
   * @param RegisterRequest $registerRequest
   */
  public function register(RegisterRequest $registerRequest): void;
}