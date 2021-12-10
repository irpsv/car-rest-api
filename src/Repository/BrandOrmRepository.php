<?php

namespace App\Repository;

use App\Domain\Brand;
use App\Domain\Brand\BrandRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Репа 
 */
class BrandOrmRepository extends ServiceEntityRepository implements BrandRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    /**
     * Создание или редактирование
     *
     * @param Brand $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(Brand $entity): void
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
     * @return Brand|null
     */
    public function getById(int $id): ?Brand
    {
        return $this->findOneBy([
            'id' => $id,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getAll($criteria = null)
    {
        return $this->findBy($criteria ?: []);
    }
}