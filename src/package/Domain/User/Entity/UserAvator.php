<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\FileImage;

class UserAvator extends Resource {
  protected $userId;
  protected $fileImage;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return UserId|null
   */
  public function getUserId(): ?UserId
  {
    return $this->userId;
  }

  /**
   * @return FileImage|null
   */
  public function getFileImage(): ?FileImage
  {
    return $this->fileImage;
  }

  /**
   * プロフィール画像ディレクトリ
   * @return string
   */
  public function getUserAvatorImagePath(): string
  {
    return '/storage/profile';
  }

  /**
   * プロフィール画像の保存名
   * @return string
   */
  public function getUserAvatorImageName(): string
  {
    return sprintf(
      "%d.%s",
      $this->getUserId()->getValue(),
      $this->getFileImage()->getExtension()
    );
  }

  /**
   * プロフィール画像の保存パス
   * @return string
   */
  public function getUserAvatorImageFilePath(): string
  {
    return sprintf(
      "%s/%s",
      $this->getUserAvatorImagePath(),
      $this->getUserAvatorImageName()
    );
  }
}