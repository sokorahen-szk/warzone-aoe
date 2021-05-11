<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use App\Models\RegisterRequestModel as EloquentRegisterRequest;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Entity\RegisterRequest;
use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Datetime;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Domain\User\ValueObject\Register\Remarks;

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

  /**
   * 待機データの登録リクエスト一覧を取得
   * @return array
   */
  public function listAtWaiting(): ?array
  {
    $registerRequests = EloquentRegisterRequest::leftJoinPlayer()
      ->select([
        'register_requests.id as register_request_id',
        'players.name as player_name',
        'register_requests.player_id',
        'register_requests.status as register_request_status',
        'players.joined_at',
        'register_requests.remarks',
      ])->get();

    if (!$registerRequests) {
      return null;
    }

    $results = [];

    foreach ($registerRequests as $registerRequest) {
      $results[] = new RegisterRequest([
        'registerId'        => new RegisterId($registerRequest->register_request_id),
        'player'            => new Player([
          'playerId'            => new PlayerId($registerRequest->player_id),
          'playerName'          => new PlayerName($registerRequest->player_name),
          'joinedAt'            => new Datetime($registerRequest->joined_at),
        ]),
        'registerStatus'    => new RegisterStatus($registerRequest->register_request_status),
        'remarks'           => new Remarks($registerRequest->remarks),
      ]);
    }

    return $results;
  }
}