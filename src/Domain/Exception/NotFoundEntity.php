<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Не найдена сущность
 */
class NotFoundEntity extends Exception
{
    public function __construct(string $entityClassName)
    {
        parent::__construct($entityClassName);
    }
}