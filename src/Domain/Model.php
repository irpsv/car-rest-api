<?php

namespace App\Domain;

use App\Domain\Exception\CantCreateWihtoutName;
use App\Domain\Exception\EntityWithoutId;
use App\Domain\Helper\IdentifiedEntity;

/**
 * Модель авто
 */
class Model
{
    use IdentifiedEntity;

    public int $brandId;
    public string $name;

    public function __construct(string $name, Brand $brand)
    {
        $name = trim($name);
        if (empty($name)) {
            throw new CantCreateWihtoutName(get_called_class());
        }
        
        if (!$brand->getId()) {
            throw new EntityWithoutId(get_class($brand));
        }
        
        $this->name = $name;
        $this->brandId = $brand->getId();
    }
}