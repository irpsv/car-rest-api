<?php

namespace App\Domain\Helper;

/**
 * Трейт для идентификатора сущностей
 */
trait IdentifiedEntity
{
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}