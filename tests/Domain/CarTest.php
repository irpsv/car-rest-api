<?php

namespace App\Tests\Domain;

use App\Domain\Car\CarService;
use App\Domain\Exception\YearNotCorrespondModification;
use App\Domain\Modification;
use App\Domain\Modification\ModificationRepository;
use App\Tests\Domain\Stub\BaseRepo;
use App\Tests\Domain\Stub\BodyTypeStubRepository;
use App\Tests\Domain\Stub\CarStubRepository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CarTest extends TestCase
{
    private CarService $service;

    /**
     * Создание сервиса
     *
     * @return CarService
     */
    private function getService(): CarService
    {
        if (!isset($this->service)) {
            $this->service = new CarService(
                $this->getModificationRepo(),
                new BodyTypeStubRepository,
                new CarStubRepository
            );
        }
        return $this->service;
    }

    /**
     * Репа с модификациями
     *
     * @return ModificationRepository
     */
    private function getModificationRepo(): ModificationRepository
    {
        $modification = $this->getDefaulModification();
        $repo = $this->getMockBuilder(ModificationRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repo->method('getById')->willReturn($modification);
        $repo->method('getAll')->willReturn([ $modification ]);

        return $repo;
    }

    /**
     * @return Modification
     */
    public function getDefaulModification(): Modification
    {
        $ref = new ReflectionClass(Modification::class);

        $modification = $ref->newInstanceWithoutConstructor();
        $modification->brandId = 5;
        $modification->modelId = 7;
        $modification->setName('3 поколение');
        $modification->productionYearStart = 2010;
        $modification->productionYearEnd = 2014;

        // указываем ид
        BaseRepo::setPropertyId($modification, 11);

        return $modification;
    }

    /**
     * Проверяем корректность создания и заполняемость репы
     *
     * @return void
     */
    public function testCreate()
    {
        $service = $this->getService();
        
        $modification = $this->getDefaulModification();
        $modificationId = 11;
        $bodyTypeId = 2; // хетчбэк

        $car = $service->create($modificationId, $bodyTypeId, 2011);
        $this->assertEquals($car->brandId, $modification->brandId);
        $this->assertEquals($car->modificationId, $modification->getId());
        $this->assertEquals($car->modelId, $modification->modelId);
        $this->assertEquals($car->bodyTypeId, $bodyTypeId);
        $this->assertEquals($car->yearProduction, 2011);

        $cars = $service->getRepo()->getAll();
        $this->assertCount(1, $cars);
        $this->assertEquals($cars[1]->getId(), $car->getId());
    }

    /**
     * Создание с указанием года выходящего за рамки модификации
     *
     * @return void
     */
    public function testCreateWithInvalidYear()
    {
        $this->expectException(YearNotCorrespondModification::class);

        $service = $this->getService();
        
        $modificationId = 11;
        $bodyTypeId = 2; // хетчбэк

        $service->create($modificationId, $bodyTypeId, 2021);
    }
}