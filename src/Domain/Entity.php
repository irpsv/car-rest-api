<?php

namespace App\Domain;

use JsonSerializable;

/**
 * Базовый класс используемой сущности
 */
abstract class Entity implements JsonSerializable
{
    /**
     * Преобрзование в массив
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}