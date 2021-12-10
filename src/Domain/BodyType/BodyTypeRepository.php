<?php

namespace App\Domain\BodyType;

use Exception;
use App\Domain\BodyType;

/**
 * Репа типов кузовов
 */
interface BodyTypeRepository
{
    /**
     * Создание или редактирование
     *
     * @param BodyType $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(BodyType $entity): void;

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
     * @return BodyType|null
     */
    public function getById(int $id): ?BodyType;

    /**
     * Поиск по условию
     *
     * @param mixed $criteria тип условия зависит от используемой ORM, если не указано то поиск всех записей
     * @param int|null $page текущая страница
     * @param int|null $size размер страница
     * @return BodyType[]
     */
    public function getAll($criteria = null, ?int $page = null, ?int $size = null);
}