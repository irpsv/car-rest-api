<?php

namespace App\Domain;

use App\Domain\Exception\CantCreateCarFuture;
use App\Domain\Exception\EntityWithoutId;
use App\Domain\Helper\IdentifiedEntity;

/**
 * АААААААвтомобиль
 */
class Car extends Entity
{
    use IdentifiedEntity;
    
    public int $brandId;
    public int $modelId;
    public int $modificationId;
    public int $bodyTypeId;
    public int $yearProduction;

    public function __construct(
        Modification $modification,
        BodyType $bodyType,
        int $yearProduction
    ) {
        if (!$modification->getId()) {
            throw new EntityWithoutId(get_class($modification));
        }

        if (!$bodyType->getId()) {
            throw new EntityWithoutId(get_class($bodyType));
        }

        $now = (int) date('Y');
        if ($yearProduction > $now) {
            throw new CantCreateCarFuture();
        }

        $modification->validateProductionYear($yearProduction);

        $this->brandId = $modification->brandId;
        $this->modelId = $modification->modelId;
        $this->modificationId = $modification->getId();
        $this->bodyTypeId = $bodyType->getId();
        $this->yearProduction = $yearProduction;
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
            'modificationId' => $this->modificationId,
            'bodyTypeId' => $this->bodyTypeId,
            'yearProduction' => $this->yearProduction,
        ];
    }
}