<?php

namespace Package\Domain;

class ValueObject {
    public function equal($obj): bool
    {
        return $obj instanceof $this && $this->value === $obj->value;
    }
}