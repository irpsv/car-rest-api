<?php

namespace App\Tests\Domain\Stub;

use Irpsv\CarRestApi\Brand;
use Irpsv\CarRestApi\Brand\BrandRepository;

/**
 * Репа марок
 */
class BrandStubRepository extends BaseRepo implements BrandRepository
{
    /**
     * @inheritDoc
     */
    public function save(Brand $entity): void
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
    public function findById(int $id): ?Brand
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