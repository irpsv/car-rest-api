<?php

namespace App\Tests\Domain\Stub;

use Irpsv\CarRestApi\BodyType;
use Irpsv\CarRestApi\BodyType\BodyTypeRepository;

/**
 * Репа кузовов
 */
class BodyTypeStubRepository extends BaseRepo implements BodyTypeRepository
{
    public function __construct()
    {
        $this->save(new BodyType('седан'));
        $this->save(new BodyType('хетчбэк'));
        $this->save(new BodyType('купе'));
    }

    /**
     * @inheritDoc
     */
    public function save(BodyType $entity): void
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
    public function findById(int $id): ?BodyType
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