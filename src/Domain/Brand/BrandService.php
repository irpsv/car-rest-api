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
     * Репа
     *
     * @return BrandRepository
     */
    public function getRepo(): BrandRepository
    {
        return $this->repo;
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
        $entity = $this->repo->getById($id);
        if (!$entity) {
            throw new NotFoundEntity(Brand::class);
        }
        
        $entity->setName($name);
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
     * Поиск записи по ид
     *
     * @param int $id
     * @return Brand|null
     */
    public function getById(int $id): ?Brand
    {
        return $this->repo->getById($id);
    }
}