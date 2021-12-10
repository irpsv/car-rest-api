<?php

namespace App\Domain\Brand;

use Exception;
use App\Domain\Brand;

/**
 * Репа марок
 */
interface BrandRepository
{
    /**
     * Создание или редактирование
     *
     * @param Brand $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(Brand $entity): void;

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
     * @return Brand|null
     */
    public function getById(int $id): ?Brand;

    /**
     * Поиск по условию
     *
     * @param mixed $criteria тип условия зависит от используемой ORM, если не указано то поиск всех записей
     * @return Brand[]
     */
    public function getAll($criteria = null);
}