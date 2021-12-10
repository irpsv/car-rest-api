<?php

namespace App\Domain\Car;

use Exception;
use App\Domain\BodyType;
use App\Domain\BodyType\BodyTypeRepository;
use App\Domain\Car;
use App\Domain\Exception\NotFoundEntity;
use App\Domain\Modification;
use App\Domain\Modification\ModificationRepository;

/**
 * Сервис для работы с авто
 */
class CarService
{
    private CarRepository $repo;
    private ModificationRepository $modificationRepo;
    private BodyTypeRepository $bodyTypeRepo;

    /**
     * @param ModificationRepository $modificationRepo
     * @param BodyTypeRepository $bodyTypeRepo
     * @param CarRepository $repo
     */
    public function __construct(
        ModificationRepository $modificationRepo,
        BodyTypeRepository $bodyTypeRepo,
        CarRepository $repo
    ) {
        $this->modificationRepo = $modificationRepo;
        $this->bodyTypeRepo = $bodyTypeRepo;
        $this->repo = $repo;
    }

    /**
     * Создание
     *
     * @param int $modificationId
     * @param int $bodyTypeId
     * @param int $yearProduction
     * @return Car
     */
    public function create(int $modificationId, int $bodyTypeId, int $yearProduction): Car
    {
        $modification = $this->modificationRepo->getById($modificationId);
        if (!$modification) {
            throw new NotFoundEntity(Modification::class);
        }

        $bodyType = $this->bodyTypeRepo->getById($bodyTypeId);
        if (!$bodyType) {
            throw new NotFoundEntity(BodyType::class);
        }

        $entity = new Car($modification, $bodyType, $yearProduction);
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param array $values
     * @return Car
     */
    public function update(int $id, array $values): Car
    {
        throw new Exception("Can't update Car entity");
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
     * @return Car[]
     */
    public function getAll($criteria = null)
    {
        return $this->repo->getAll($criteria);
    }

    /**
     * Поиск записи по ид
     *
     * @param int $id
     * @return Car|null
     */
    public function getById(int $id): ?Car
    {
        return $this->repo->getById($id);
    }
}