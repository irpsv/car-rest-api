<?php

namespace App\Tests\Domain\Stub;

use ReflectionClass;

/**
 * Базовая репа для тестов
 */
abstract class BaseRepo
{
    /**
     * У каждой репы свой счетчик, не сквозной ид
     *
     * @var int
     */
    private int $currentId = 0;
    private array $items = [];

    /**
     * Принудительно указывает свойство id
     *
     * @param object $object
     * @param int $id
     * @return void
     */
    public static function setPropertyId(object $object, int $id)
    {
        $ref = new ReflectionClass($object);
        $refProp = $ref->getProperty('id');
        $refProp->setAccessible(true);
        $refProp->setValue($object, $id);
    }

    /**
     * Список элементов
     *
     * @return array
     */
    protected function getItems(): array
    {
        return $this->items;
    }

    /**
     * Создание
     *
     * @param object $object
     * @return void
     */
    protected function createItem(object $object)
    {
        $this->currentId++;

        $this->items[$this->currentId] = $object;

        self::setPropertyId($object, $this->currentId);
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param object $object
     * @return void
     */
    protected function updateItem(int $id, object $object)
    {
        $this->items[$id] = $object;
    }

    /**
     * Удаление
     *
     * @param int $id
     * @return void
     */
    protected function deleteItem(int $id)
    {
        unset($this->items[$id]);
    }
}