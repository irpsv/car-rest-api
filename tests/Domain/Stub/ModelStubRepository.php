<?php

namespace App\Tests\Domain\Stub;

use Irpsv\CarRestApi\Model;
use Irpsv\CarRestApi\Model\ModelRepository;

/**
 * Репа моделей
 */
class ModelStubRepository extends BaseRepo implements ModelRepository
{
    /**
     * @inheritDoc
     */
    public function save(Model $entity): void
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
    public function findById(int $id): ?Model
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