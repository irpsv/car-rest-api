<?php

namespace App\Domain\Modification;

use Exception;
use App\Domain\Modification;

/**
 * Репа модификаций
 */
interface ModificationRepository
{
    /**
     * Создание или редактирование
     *
     * @param Modification $entity
     * @return void
     * @throws Exception в случае ошибок
     */
    public function save(Modification $entity): void;

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
     * @return Modification|null
     */
    public function findById(int $id): ?Modification;

    /**
     * Поиск по условию
     *
     * @param mixed $criteria тип условия зависит от используемой ORM, если не указано то поиск всех записей
     * @return Modification[]
     */
    public function find($criteria = null);
}