<?php

namespace App\Tests\Domain\Stub;

use App\Domain\Model;
use App\Domain\Model\ModelRepository;

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
    public function getById(int $id): ?Model
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