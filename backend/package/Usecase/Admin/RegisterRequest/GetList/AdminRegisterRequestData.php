<?php

namespace Package\Usecase\Admin\RegisterRequest\GetList;

use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AdminRegisterRequestData extends Data {
  public $registerRequests;

  public function __construct(array $sources)
  {
    $resources = [];
    foreach ($sources as $source) {
      $resources[] = [
        'id'          => $source->getRegisterId()->getValue(),
        'userId'      => $source->getUser()->getId()->getValue(),
        'userName'    => $source->getUser()->getName()->getValue(),
        'createdAt'   => $source->getUser()->getCreatedAt()->getDatetime(),
        'status'      => $source->getRegisterStatus()->getValue(),
        'remarks'     => $source->getRemarks()->getValue(),
      ];
    }
    $this->registerRequests = $resources;
  }
}