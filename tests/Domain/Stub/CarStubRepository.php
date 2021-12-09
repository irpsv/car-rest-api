<?php

namespace App\Tests\Domain\Stub;

use Irpsv\CarRestApi\Car;
use Irpsv\CarRestApi\Car\CarRepository;

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
    public function findById(int $id): ?Car
    {
        return $this->getItems()[$id] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function find($criteria = null)
    {
        return $this->getItems();
    }
}