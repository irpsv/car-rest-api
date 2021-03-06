<?php

namespace App\Domain\Model;

use App\Domain\Brand;
use App\Domain\Brand\BrandRepository;
use App\Domain\Exception\NotFoundEntity;
use App\Domain\Model;

/**
 * Сервис для работы с моделями
 */
class ModelService
{
    private BrandRepository $brandRepo;
    private ModelRepository $repo;

    /**
     * @param BrandRepository $brandRepo
     * @param ModelRepository $repo
     */
    public function __construct(
        BrandRepository $brandRepo,
        ModelRepository $repo
    ) {
        $this->brandRepo = $brandRepo;
        $this->repo = $repo;
    }

    /**
     * Репа
     *
     * @return ModelRepository
     */
    public function getRepo(): ModelRepository
    {
        return $this->repo;
    }

    /**
     * Создание
     *
     * @param int $brandId
     * @param string $name
     * @return Model
     */
    public function create(int $brandId, string $name): Model
    {
        $brand = $this->brandRepo->getById($brandId);
        if (!$brand) {
            throw new NotFoundEntity(Brand::class);
        }

        $entity = new Model($name, $brand);
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param string $name
     * @return Model
     */
    public function update(int $id, string $name): Model
    {
        $entity = $this->repo->getById($id);
        if (!$entity) {
            throw new NotFoundEntity(Model::class);
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
     * Поиск записи по ид
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->repo->getById($id);
    }
}