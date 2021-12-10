<?php

namespace App\Tests\Domain;

use App\Domain\Brand;
use App\Domain\Car\CarService;
use App\Domain\Exception\YearNotCorrespondModification;
use App\Domain\Model;
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
    private BodyTypeStubRepository $bodyTypeRepo;

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
                $this->bodyTypeRepo = new BodyTypeStubRepository,
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
        $modification->brand = new Brand('BMW');
        $modification->model = new Model('X3', $modification->brand);
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

        $bodyTypeId = 2;
        $bodyType = $this->bodyTypeRepo->getById($bodyTypeId);

        $car = $service->create($modificationId, $bodyTypeId, 2011);
        $this->assertEquals($car->brand, $modification->brand);
        $this->assertEquals($car->modification, $modification);
        $this->assertEquals($car->model, $modification->model);
        $this->assertEquals($car->bodyType, $bodyType);
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