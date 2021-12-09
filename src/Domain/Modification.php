<?php

namespace App\Domain;

use App\Domain\Exception\CantCreateWihtoutName;
use App\Domain\Exception\EntityWithoutId;
use App\Domain\Exception\YearNotCorrespondModification;
use App\Domain\Helper\IdentifiedEntity;

/**
 * Модификация авто
 */
class Modification
{
    use IdentifiedEntity;
    
    public int $brandId;
    public int $modelId;
    public string $name;
    public int $productionYearStart;
    /**
     * Если null - значит производится до сих пор
     *
     * @var int|null
     */
    public ?int $productionYearEnd;

    public function __construct(
        string $name,
        Model $model,
        int $productionYearStart,
        ?int $productionYearEnd = null
    ) {
        $name = trim($name);
        if (empty($name)) {
            throw new CantCreateWihtoutName(get_called_class());
        }
        
        if (!$model->getId()) {
            throw new EntityWithoutId(get_class($model));
        }

        $this->name = $name;
        $this->modelId = $model->getId();
        $this->brandId = $model->brandId;
        $this->productionYearStart = $productionYearStart;
        $this->productionYearEnd = $productionYearEnd;
    }

    /**
     * Проверяем соответствует ли год модификации
     *
     * @param int $year
     * @return void
     */
    public function validateProductionYear(int $year): void
    {
        $correct = $this->productionYearEnd
            ? $this->productionYearStart <= $year && $year <= $this->productionYearEnd
            : $this->productionYearStart <= $year;
        
        if (!$correct) {
            throw new YearNotCorrespondModification($year, $this);
        }
    }
}