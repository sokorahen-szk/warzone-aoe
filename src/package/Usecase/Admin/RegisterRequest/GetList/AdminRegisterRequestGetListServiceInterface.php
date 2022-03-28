<?php declare(strict_types=1);

namespace Package\Usecase\Admin\RegisterRequest\GetList;
use Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestData;

interface AdminRegisterRequestGetListServiceInterface {
  public function handle(): ?AdminRegisterRequestData;
}