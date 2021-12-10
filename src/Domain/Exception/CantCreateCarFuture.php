<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Нельзя создать автомобиль с будущей датой
 */
class CantCreateCarFuture extends Exception
{
    public function __construct()
    {
        parent::__construct("Can't create car with future production date");
    }
}