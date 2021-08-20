<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use App\Models\RegisterRequestModel as EloquentRegisterRequest;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Entity\RegisterRequest;
use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Infrastructure\Eloquent\Converter;

use Exception;

class RegisterRequestRepository implements RegisterRequestRepositoryInterface {
  /**
   * 登録リクエスト作成
   * @param RegisterRequest $registerRequest
   */
  public function register(RegisterRequest $registerRequest): void
  {
    EloquentRegisterRequest::create([
      'user_id' => $registerRequest->getUserId()->getValue(),
    ]);
  }

  /**
   * 待機データの登録リクエスト一覧を取得
   * @return null|RegisterRequest[]
   */
  public function listAtWaiting(): ?array
  {
    $registerRequests = EloquentRegisterRequest::with('user')
      ->where('status', RegisterStatus::REGISTER_REQUEST_STATUS_WAITING)
      ->orderBy('id', 'desc')
      ->get();

    if (!$registerRequests) {
      return null;
    }

    return Converter::registerRequests($registerRequests);
  }

  /**
   * 登録リクエスト取得する
   * @param RegisterId $registerId
   * @return RegisterRequest
   * @throws Exception
   */
  public function get(RegisterId $registerId): RegisterRequest
  {
    $registerRequest = EloquentRegisterRequest::with('user')
      ->find($registerId->getValue());

    if (!$registerRequest) {
      throw new Exception("レコードがありません。");
    }

    return Converter::registerRequest($registerRequest);
  }

  /**
   * 登録リクエストの情報更新
   * @param RegisterRequest $registerRequest
   */
  public function update(RegisterRequest $registerRequest): void
  {
    if(!EloquentRegisterRequest::find($registerRequest->getRegisterId()->getValue())
    ->update([
      'user_id'             => $registerRequest->getUserId()->getValue(),
      'created_by_user_id'  => $registerRequest->getCreatedByUserId()->getValue(),
      'status'              => $registerRequest->getRegisterStatus()->getValue(),
      'remarks'             => $registerRequest->getRemarks()->getValue(),
    ])) {
      throw new Exception("更新に失敗しました。");
    }
  }
}