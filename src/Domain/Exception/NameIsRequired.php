<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Имя обязательное свойство
 */
class NameIsRequired extends Exception
{
    /**
     * @param string $className имя класса инициировавшего ошибку
     */
    public function __construct(string $className)
    {
        parent::__construct("Name is required in '{$className}'");
    }
}