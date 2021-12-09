<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Сущность без id
 */
class EntityWithoutId extends Exception
{
    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        parent::__construct($className);
    }
}