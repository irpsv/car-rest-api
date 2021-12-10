<?php

namespace App\Domain;

use App\Domain\Exception\NameIsRequired;
use App\Domain\Helper\IdentifiedEntity;
use App\Domain\Helper\Nameable;

/**
 * Тип кузова
 */
class BodyType extends Entity
{
    use IdentifiedEntity;
    use Nameable;
    
    protected string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->name,
        ];
    }
}