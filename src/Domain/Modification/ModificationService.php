<?php

namespace App\Domain\Modification;

use App\Domain\Exception\NotFoundEntity;
use App\Domain\Helper\ArrayHelper;
use App\Domain\Model;
use App\Domain\Model\ModelRepository;
use App\Domain\Modification;

/**
 * Сервис для работы с модификациями
 */
class ModificationService
{
    private ModelRepository $modelRepo;
    private ModificationRepository $repo;

    /**
     * @param ModelRepository $modelRepo
     * @param ModificationRepository $repo
     */
    public function __construct(
        ModelRepository $modelRepo,
        ModificationRepository $repo
    ) {
        $this->modelRepo = $modelRepo;
        $this->repo = $repo;
    }

    /**
     * Создание
     *
     * @param int $modelId
     * @param array $values список значений
     * @return Modification
     */
    public function create(int $modelId, array $values): Modification
    {
        ArrayHelper::existAllFields($values, [
            'name',
            'productionYearStart',
        ]);

        $model = $this->modelRepo->findById($modelId);
        if (!$model) {
            throw new NotFoundEntity(Model::class);
        }

        $name = (string) $values['name'];
        $productionYearStart = (int) $values['productionYearStart'];
        $productionYearEnd = $values['productionYearEnd'] ?? null;

        $entity = new Modification($name, $model, $productionYearStart, intval($productionYearEnd));
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param array $values список значений
     * @return Modification
     */
    public function update(int $id, array $values): Modification
    {
        $entity = $this->repo->findById($id);
        if (!$entity) {
            throw new NotFoundEntity(Modification::class);
        }

        $isChanged = ArrayHelper::fillIfExist($entity, $values, [
            'name',
            'productionYearStart',
            'productionYearEnd',
        ]);
        if ($isChanged) {
            $this->repo->save($entity);
        }

        return $entity;
    }

    /**
     * Удаление
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        // удаление без проверок
        $this->repo->delete($id);
    }

    /**
     * Поиск записей
     *
     * @param mixed $criteria
     * @return Modification[]
     */
    public function find($criteria = null)
    {
        return $this->repo->find($criteria);
    }

    /**
     * Поиск записи по ид
     *
     * @param int $id
     * @return Modification|null
     */
    public function findById(int $id): ?Modification
    {
        return $this->repo->findById($id);
    }
}