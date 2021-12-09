<?php

namespace App\Domain\Brand;

use App\Domain\Brand;
use App\Domain\Exception\NotFoundEntity;

/**
 * Сервис для работы с марками
 */
class BrandService
{
    private BrandRepository $repo;

    /**
     * @param BrandRepository $repo
     */
    public function __construct(
        BrandRepository $repo
    ) {
        $this->repo = $repo;
    }

    /**
     * Создание
     *
     * @param string $name
     * @return Brand
     */
    public function create(string $name): Brand
    {
        $entity = new Brand($name);
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param string $name
     * @return Brand
     */
    public function update(int $id, string $name): Brand
    {
        $entity = $this->repo->findById($id);
        if (!$entity) {
            throw new NotFoundEntity(Brand::class);
        }
        
        $entity->name = $name;
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Удаление
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        // удаление без проверок
        $this->repo->delete($id);
    }

    /**
     * Поиск записей
     *
     * @param mixed $criteria
     * @return Brand[]
     */
    public function find($criteria = null)
    {
        return $this->repo->find($criteria);
    }

    /**
     * Поиск записи по ид
     *
     * @param int $id
     * @return Brand|null
     */
    public function findById(int $id): ?Brand
    {
        return $this->repo->findById($id);
    }
}