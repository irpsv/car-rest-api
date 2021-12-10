<?php

namespace App\Domain;

use App\Domain\Exception\YearNotCorrespondModification;
use App\Domain\Helper\IdentifiedEntity;
use App\Domain\Helper\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Модификация авто
 * 
 * @ORM\Entity
 */
class Modification extends Entity
{
    use IdentifiedEntity;
    use Nameable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    public Brand $brand;
    /**
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    public Model $model;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    public int $productionYearStart;
    /**
     * @var int|null если null - значит производится до сих пор
     * @ORM\Column(type="integer")
     */
    public ?int $productionYearEnd;

    public function __construct(
        string $name,
        Model $model,
        int $productionYearStart,
        ?int $productionYearEnd = null
    ) {
        $this->setName($name);
        $this->model = $model;
        $this->brand = $model->brand;
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
            'brand' => $this->brand,
            'model' => $this->model,
            'name' => $this->name,
            'productionYearStart' => $this->productionYearStart,
            'productionYearEnd' => $this->productionYearEnd,
        ];
    }
}