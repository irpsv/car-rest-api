<?php

namespace App\Tests\Domain\Stub;

use App\Domain\Modification;
use App\Domain\Modification\ModificationRepository;

/**
 * Репа модификаций
 */
class ModificationStubRepository extends BaseRepo implements ModificationRepository
{
    /**
     * @inheritDoc
     */
    public function save(Modification $entity): void
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
    public function getById(int $id): ?Modification
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