<?php

namespace App\Domain\Brand;

use App\Domain\Brand;
use App\Domain\Exception\NotFoundEntity;

/**
 * Сервис для работы с марками
 */
class BrandService
{
    private BrandRepository $repo;

    /**
     * @param BrandRepository $repo
     */
    public function __construct(
        BrandRepository $repo
    ) {
        $this->repo = $repo;
    }

    /**
     * Репа
     *
     * @return BrandRepository
     */
    public function getRepo(): BrandRepository
    {
        return $this->repo;
    }

    /**
     * Создание
     *
     * @param string $name
     * @return Brand
     */
    public function create(string $name): Brand
    {
        $entity = new Brand($name);
        $this->repo->save($entity);

        return $entity;
    }

    /**
     * Редактирование
     *
     * @param int $id
     * @param string $name
     * @return Brand
     */
    public function update(int $id, string $name): Brand
    {
        $entity = $this->repo->getById($id);
        if (!$entity) {
            throw new NotFoundEntity(Brand::class);
        }
        
        $entity->setName($name);
        $this->repo->save($entity);

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
     * Поиск записи по ид
     *
     * @param int $id
     * @return Brand|null
     */
    public function getById(int $id): ?Brand
    {
        return $this->repo->getById($id);
    }

    /**
     * Генерирует данные
     *
     * @return void
     */
    public function generate(): void
    {
        $names = [
            "AUDI",
            "ACURA",
            "ALFA ROMEO",
            "ASTON MARTIN",
            "BENTLEY",
            "BYD",
            "BMW",
            "BRILLIANCE",
            "BUICK",
            "BUGATTI",
            "CADILLAC",
            "CHANGAN",
            "CHEVROLET",
            "CHERY",
            "CHRYSLER",
            "CITROEN",
            "DAEWOO",
            "DACIA",
            "DAIHATSU",
            "DODGE",
            "FAW",
            "FERRARI",
            "FIAT",
            "FORD",
            "GEELY",
            "GMC",
            "GREAT WALL",
            "HONDA",
            "HUMMER",
            "HYUNDAI",
            "INFINITI",
            "JAGUAR",
            "JEEP",
            "KIA",
            "LAMBORGHINI",
            "LAND ROVER",
            "LANCIA",
            "LEXUS",
            "LIFAN",
            "LINCOLN",
            "LOTUS",
            "MARUSSIA",
            "MAYBACH",
            "MAZDA",
            "MERCEDES",
            "MASERATI",
            "MINI",
            "MCLAREN",
            "MITSUBISHI",
            "NISSAN",
            "OPEL",
            "PEUGEOT",
            "PORSCHE",
            "RENAULT",
            "SAAB",
            "SEAT",
            "SKODA",
            "SUBARU",
            "SUZUKI",
            "TOYOTA",
            "PONTIAC",
            "ROLLS-ROYCE",
            "SMART",
            "SSANGYONG",
            "TESLA",
            "VOLVO",
            "VOLKSWAGEN",
            "ВАЗ",
            "ГАЗ",
            "ЗАЗ",
            "TAGAZ",
            "УАЗ",
            "МОТОЦИКЛ",
            "HAVAL",
            "ROVER",
            "МОСКВИЧ",
            "DATSUN",
            "GAC",
            "GENESIS",
            "EXEED",
            "МОСКВИЧ",
        ];

        foreach ($names as $name) {
            $this->create($name);
        }
    }
}