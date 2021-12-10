<?php

namespace App\Domain\Car;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\HttpFoundation\Request;

/**
 * Фильтр по машинам
 */
class CarFilter
{
    private ?array $brandIds = null;
    private ?array $bodyTypeIds = null;
    private ?int $yearProductionFrom = null;
    private ?int $yearProductionTo = null;

    /**
     * @param array $filter
     */
    public function __construct(array $filter)
    {
        $value = (string) ($filter['brands'] ?? '');
        if ($value) {
            $this->brandIds = array_filter(explode(',', $value));
        }

        $value = (string) ($filter['bodyTypes'] ?? '');
        if ($value) {
            $this->bodyTypeIds = array_filter(explode(',', $value));
        }

        if (isset($filter['yearProductionFrom'])) {
            $this->yearProductionFrom = (int) $filter['yearProductionFrom'];
        }

        if (isset($filter['yearProductionTo'])) {
            $this->yearProductionTo = (int) $filter['yearProductionTo'];
        }
    }

    /**
     * Создать фильтр из запроса
     *
     * @param Request $request
     * @return self
     */
    public static function createFromRequest(Request $request): self
    {
        return new static($request->query->all());
    }

    /**
     * Условия для доктрины
     *
     * @return array
     */
    public function getCriteria(): Criteria
    {
        $criteria = Criteria::create();

        if ($this->brandIds) {
            $criteria->andWhere(
                $criteria->expr()->in('brand', $this->brandIds)
            );
        }

        if ($this->bodyTypeIds) {
            $criteria->andWhere(
                $criteria->expr()->in('bodyType', $this->bodyTypeIds)
            );
        }

        if ($this->yearProductionFrom) {
            $criteria->andWhere(new Comparison('yearProduction', '>=', $this->yearProductionFrom));
        }

        if ($this->yearProductionTo) {
            $criteria->andWhere(new Comparison('yearProduction', '<=', $this->yearProductionTo));
        }

        return $criteria;
    }
}