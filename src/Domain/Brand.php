<?php

namespace App\Domain;

use App\Domain\Exception\CantCreateWihtoutName;
use App\Domain\Helper\IdentifiedEntity;

/**
 * Бренд авто
 */
class Brand
{
    use IdentifiedEntity;
    
    public string $name;

    public function __construct(string $name)
    {
        $name = trim($name);
        if (empty($name)) {
            throw new CantCreateWihtoutName(get_called_class());
        }

        $this->name = $name;
    }
}