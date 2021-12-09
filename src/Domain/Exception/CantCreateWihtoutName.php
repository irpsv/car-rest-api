<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Нельзя создать запись без имени
 */
class CantCreateWihtoutName extends Exception
{
    /**
     * @param string $className имя класса инициировавшего ошибку
     */
    public function __construct(string $className)
    {
        parent::__construct($className);
    }
}