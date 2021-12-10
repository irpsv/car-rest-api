<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Массив не содержит обязательные поля
 */
class ArrayNotExistRequiredField extends Exception
{
    /**
     * @param array $names список отсутствующих полей
     */
    public function __construct(array $names)
    {
        $names = array_map(fn($name) => "'{$name}'", $names);
        $message = join(", ", $names);

        parent::__construct("Array is not exist required fields: {$message}");
    }
}