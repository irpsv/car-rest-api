<?php

namespace App\Domain;

use App\Domain\Exception\CantCreateCarFuture;
use App\Domain\Helper\IdentifiedEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * АААААААвтомобиль
 * 
 * @ORM\Entity
 */
class Car extends Entity
{
    use IdentifiedEntity;
    
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
     * @ORM\ManyToOne(targetEntity="Modification")
     * @ORM\JoinColumn(name="modification_id", referencedColumnName="id")
     */
    public Modification $modification;
    /**
     * @ORM\ManyToOne(targetEntity="BodyType")
     * @ORM\JoinColumn(name="body_type_id", referencedColumnName="id")
     */
    public BodyType $bodyType;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    public int $yearProduction;

    public function __construct(
        Modification $modification,
        BodyType $bodyType,
        int $yearProduction
    ) {
        $now = (int) date('Y');
        if ($yearProduction > $now) {
            throw new CantCreateCarFuture();
        }

        $modification->validateProductionYear($yearProduction);

        $this->brand = $modification->brand;
        $this->model = $modification->model;
        $this->modification = $modification;
        $this->bodyType = $bodyType;
        $this->yearProduction = $yearProduction;
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
            'modification' => $this->modification,
            'bodyType' => $this->bodyType,
            'yearProduction' => $this->yearProduction,
        ];
    }
}