<?php

namespace App\Domain\BodyType;

use App\Domain\BodyType;
use App\Domain\Exception\NotFoundEntity;

/**
 * Сервис для работы с типами кузовов
 */
class BodyTypeService
{
    private BodyTypeRepository $repo;

    /**
     * @param BodyTypeRepository $repo
     */
    public function __construct(
        BodyTypeRepository $repo
    ) {
        $this->repo = $repo;
    }

    /**
     * Репа
     *
     * @return BodyTypeRepository
     */
    public function getRepo(): BodyTypeRepository
    {
        return $this->repo;
    }

    /**
     * Создание
     *
     * @param string $name
     * @return BodyType
     */
    public function create(string $name): BodyType
    {
        $entity = new BodyType($name);
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param string $name
     * @return BodyType
     */
    public function update(int $id, string $name): BodyType
    {
        $entity = $this->repo->getById($id);
        if (!$entity) {
            throw new NotFoundEntity(BodyType::class);
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
     * @return BodyType|null
     */
    public function getById(int $id): ?BodyType
    {
        return $this->repo->getById($id);
    }
}