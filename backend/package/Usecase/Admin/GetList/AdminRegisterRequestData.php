<?php

namespace Package\Usecase\Admin\GetList;

use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AdminRegisterRequestData extends Data {
  public $registerRequests;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'id'        => $source->getRegisterId()->getValue(),
        'playerId'  => $source->getPlayerId()->getValue(),
        'status'    => $source->getRegisterStatus()->getValue(),
        'remarks'   => $source->getRemarks()->getValue(),
      ];
    }
    $this->registerRequests = $response;
  }
}