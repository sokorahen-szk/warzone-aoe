<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use App\Models\RegisterRequestModel as EloquentRegisterRequest;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Entity\RegisterRequest;

class RegisterRequestRepository implements RegisterRequestRepositoryInterface {
  /**
   * 登録リクエスト作成
   * @param RegisterRequest $registerRequest
   */
  public function register(RegisterRequest $registerRequest): void
  {
    EloquentRegisterRequest::create([
      'player_id'       => $registerRequest->getPlayerId()->getValue(),
    ]);
  }
}