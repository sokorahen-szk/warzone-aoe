<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

use Illuminate\Http\UploadedFile;

use Package\Domain\User\Exceptions\UserImageFileNullException;

class FileImage {
  private $value;

  public function __construct(?UploadedFile $value)
  {
    if (!$value) {
      throw new UserImageFileNullException('画像のアップロードに失敗しました。');
    }

    return $this->value = $value;
  }

  public function getValue(): UploadedFile
  {
    return $this->value;
  }

  /**
   * 画像の拡張子を返す
   * @param string
   */
  public function getExtension(): string
  {
    return $this->value->extension();
  }

}