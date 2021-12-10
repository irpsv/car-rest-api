<?php

namespace App\Domain;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Базовый класс используемой сущности
 */
abstract class Entity implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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