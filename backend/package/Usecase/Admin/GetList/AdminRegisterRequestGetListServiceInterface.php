<?php declare(strict_types=1);

namespace Package\Usecase\Admin\GetList;
use Package\Usecase\Admin\GetList\AdminRegisterRequestData;

interface AdminRegisterRequestGetListServiceInterface {
  public function handle(): ?AdminRegisterRequestData;
}