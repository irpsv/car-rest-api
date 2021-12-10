<?php

namespace App\Repository;

use App\Domain\Car;
use App\Domain\Car\CarRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Репа 
 */
class CarOrmRepository extends ServiceEntityRepository implements CarRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * Создание или редактирование
     *
     * @param Car $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(Car $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Удаление
     *
     * @param int $id
     * @return void
     * @throws Exception в случае ошибок
     */
    public function delete(int $id): void
    {
        $entity = $this->getById($id);
        if ($entity) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Поиск по ид
     *
     * @param int $id
     * @return Car|null
     */
    public function getById(int $id): ?Car
    {
        return $this->findOneBy([
            'id' => $id,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getAll($criteria = null, ?int $page = null, ?int $size = null)
    {
        $limit = $size ?: null;
        $offset = $page ? ($page-1) * $limit : null;

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;

            if ($limit) {
                $criteria->setMaxResults($size);
            }
            if ($offset) {
                $criteria->setFirstResult($offset);
            }

            return $this->matching($criteria)->toArray();
        }
        return $this->findBy($criteria ?: [], ['id' => 'asc'], $limit, $offset);
    }
}