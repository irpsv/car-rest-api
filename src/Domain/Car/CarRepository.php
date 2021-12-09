<?php

namespace App\Domain\Car;

use Exception;
use App\Domain\Car;

/**
 * Репа авто
 */
interface CarRepository
{
    /**
     * Создание или редактирование
     *
     * @param Car $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(Car $entity): void;

    /**
     * Удаление
     *
     * @param int $id
     * @return void
     * @throws Exception в случае ошибок
     */
    public function delete(int $id): void;

    /**
     * Поиск по ид
     *
     * @param int $id
     * @return Car|null
     */
    public function findById(int $id): ?Car;

    /**
     * Поиск по условию
     *
     * @param mixed $criteria тип условия зависит от используемой ORM, если не указано то поиск всех записей
     * @return Car[]
     */
    public function find($criteria = null);
}