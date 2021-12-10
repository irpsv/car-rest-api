<?php

namespace App\Tests\Domain\Stub;

use App\Domain\Car;
use App\Domain\Car\CarRepository;

/**
 * Репа авто
 */
class CarStubRepository extends BaseRepo implements CarRepository
{
    /**
     * @inheritDoc
     */
    public function save(Car $entity): void
    {
        if ($id = $entity->getId()) {
            $this->updateItem($id, $entity);
        }
        else {
            $this->createItem($entity);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->deleteItem($id);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Car
    {
        return $this->getItems()[$id] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getAll($criteria = null, ?int $page = null, ?int $size = null)
    {
        return $this->getItems();
    }
}