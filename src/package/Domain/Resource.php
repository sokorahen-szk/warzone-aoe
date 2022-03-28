<?php

namespace Package\Domain;

class Resource {
  public function __construct(array $data = [])
  {
    foreach($data as $key => $value) {
      $this->{$key} = $value;
    }
  }

  public function __set($name, $value)
  {
    if ($value) $this->{$name} = $value;
  }

  public function __get($name)
  {
    return $this->{$name} ?: null;
  }

}