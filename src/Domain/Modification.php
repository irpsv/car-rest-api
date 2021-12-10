<?php

namespace App\Domain;

use App\Domain\Exception\NameIsRequired;
use App\Domain\Exception\EntityWithoutId;
use App\Domain\Exception\YearNotCorrespondModification;
use App\Domain\Helper\IdentifiedEntity;
use App\Domain\Helper\Nameable;

/**
 * Модификация авто
 */
class Modification extends Entity
{
    use IdentifiedEntity;
    use Nameable;
    
    public int $brandId;
    public int $modelId;
    protected string $name;
    public int $productionYearStart;
    /**
     * @var int|null если null - значит производится до сих пор
     */
    public ?int $productionYearEnd;

    public function __construct(
        string $name,
        Model $model,
        int $productionYearStart,
        ?int $productionYearEnd = null
    ) {
        if (!$model->getId()) {
            throw new EntityWithoutId(get_class($model));
        }

        $this->setName($name);
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

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'brandId' => $this->brandId,
            'modelId' => $this->modelId,
            'name' => $this->name,
            'productionYearStart' => $this->productionYearStart,
            'productionYearEnd' => $this->productionYearEnd,
        ];
    }
}