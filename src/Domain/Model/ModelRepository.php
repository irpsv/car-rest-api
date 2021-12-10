<?php

namespace App\Domain\Model;

use Exception;
use App\Domain\Model;

/**
 * Репа моделей
 */
interface ModelRepository
{
    /**
     * Создание или редактирование
     *
     * @param Model $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(Model $entity): void;

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
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Поиск по условию
     *
     * @param mixed $criteria тип условия зависит от используемой ORM, если не указано то поиск всех записей
     * @param int|null $page текущая страница
     * @param int|null $size размер страница
     * @return Brand[]
     */
    public function getAll($criteria = null, ?int $page = null, ?int $size = null);
}