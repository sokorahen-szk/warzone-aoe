<?php

namespace Package\Usecase;

class Data {
  public function getVars(): array
  {
    $objects = get_object_vars($this);
    if (!$objects) return [];

    return $objects;
  }
}