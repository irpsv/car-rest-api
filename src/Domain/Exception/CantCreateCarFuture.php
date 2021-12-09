<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Нельзя создать автомобиль с будущей датой
 */
class CantCreateCarFuture extends Exception
{

}