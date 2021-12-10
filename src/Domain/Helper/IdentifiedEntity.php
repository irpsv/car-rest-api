<?php

namespace App\Domain\Helper;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт для идентификатора сущностей
 */
trait IdentifiedEntity
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
}