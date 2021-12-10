<?php

namespace App\Domain;

use App\Domain\Exception\NameIsRequired;
use App\Domain\Exception\EntityWithoutId;
use App\Domain\Helper\IdentifiedEntity;
use App\Domain\Helper\Nameable;

/**
 * Модель авто
 */
class Model extends Entity
{
    use IdentifiedEntity;
    use Nameable;
    
    public int $brandId;
    protected string $name;

    public function __construct(string $name, Brand $brand)
    {
        if (!$brand->getId()) {
            throw new EntityWithoutId(get_class($brand));
        }
        
        $this->setName($name);
        $this->brandId = $brand->getId();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'brandId' => $this->brandId,
            'name' => $this->name,
        ];
    }
}