<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\Entity\RegisterRequest;
use Package\Domain\User\ValueObject\Register\RegisterId;

interface RegisterRequestRepositoryInterface {
  /**
   * 登録リクエスト作成
   * @param RegisterRequest $registerRequest
   */
  public function register(RegisterRequest $registerRequest): void;

  /**
   * 待機データの登録リクエスト一覧を取得
   * @return null|RegisterRequest[]
   */
  public function listAtWaiting(): ?array;

  /**
   * 登録リクエスト取得する
   * @param RegisterId $registerId
   * @return RegisterRequest
   */
  public function get(RegisterId $registerId): RegisterRequest;

  /**
   * 登録リクエストの情報更新
   * @param RegisterRequest $registerRequest
   */
  public function update(RegisterRequest $registerRequest): void;
}