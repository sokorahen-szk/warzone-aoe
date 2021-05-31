<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use App\Models\RegisterRequestModel as EloquentRegisterRequest;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Entity\RegisterRequest;
use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Enabled;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Domain\User\ValueObject\Register\Remarks;

use Package\Domain\System\ValueObject\Datetime;

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
      ->where('register_requests.status', RegisterStatus::REGISTER_REQUEST_STATUS_WAITING)
      ->orderBy('register_requests.id', 'desc')
      ->select([
        'register_requests.id as register_request_id',
        'register_requests.player_id',
        'register_requests.status as register_request_status',
        'register_requests.remarks',
        'players.name as player_name',
        'players.joined_at',
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

  /**
   * 登録リクエスト取得する
   * @param RegisterId $registerId
   * @return RegisterRequest
   */
  public function get(RegisterId $registerId): RegisterRequest
  {
    $registerRequest = EloquentRegisterRequest::where('register_requests.id', $registerId->getValue())
      ->leftJoinPlayer()
      ->select([
        'register_requests.id as register_request_id',
        'register_requests.player_id',
        'register_requests.status as register_request_status',
        'register_requests.remarks',
        'players.name as player_name',
        'players.joined_at',
        'players.enabled',
      ])->first();

    if (!$registerRequest) {
      throw new \Exception("レコードがありません。");
    }

    return new RegisterRequest([
      'registerId'        => new RegisterId($registerRequest->register_request_id),
      'player'            => new Player([
        'playerId'            => new PlayerId($registerRequest->player_id),
        'playerName'          => new PlayerName($registerRequest->player_name),
        'enabled'             => new Enabled($registerRequest->enabled),
      ]),
      'registerStatus'    => new RegisterStatus($registerRequest->register_request_status),
      'remarks'           => new Remarks($registerRequest->remarks),
    ]);
  }

  /**
   * 登録リクエストの情報更新
   * @param RegisterRequest $registerRequest
   */
  public function update(RegisterRequest $registerRequest): void
  {
    if(!EloquentRegisterRequest::find($registerRequest->getRegisterId()->getValue())
    ->update([
      'user_id'   => $registerRequest->getUserId()->getValue(),
      'status'    => $registerRequest->getRegisterStatus()->getValue(),
      'remarks'   => $registerRequest->getRemarks()->getValue(),
    ])) {
      throw new \Exception("更新に失敗しました。");
    }
  }
}