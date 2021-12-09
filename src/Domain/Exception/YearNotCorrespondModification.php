<?php

namespace App\Domain\Exception;

use Exception;
use App\Domain\Modification;

/**
 * Год производства не соответствует модификации
 */
class YearNotCorrespondModification extends Exception
{
    public int $year;
    public Modification $modification;
    
    public function __construct(int $year, Modification $modification)
    {
        $this->year = $year;
        $this->modification = $modification;

        $start = $modification->productionYearStart;
        $end = $modification->productionYearEnd ?: 'now';

        $message = "Year '{$year}' not correspond modifcaition years '{$start}-{$end}'";

        parent::__construct($message);
    }
}