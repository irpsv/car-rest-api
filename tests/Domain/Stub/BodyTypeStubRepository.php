<?php

namespace App\Tests\Domain\Stub;

use App\Domain\BodyType;
use App\Domain\BodyType\BodyTypeRepository;

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
    public function getById(int $id): ?BodyType
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