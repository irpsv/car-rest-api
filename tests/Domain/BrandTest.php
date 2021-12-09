<?php

namespace App\Tests\Domain;

use App\Domain\Brand\BrandService;
use App\Domain\Exception\CantCreateWihtoutName;
use App\Tests\Domain\Stub\BrandStubRepository;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    private BrandService $service;

    /**
     * Создание сервиса
     *
     * @return BrandService
     */
    private function getService(): BrandService
    {
        if (!isset($this->service)) {
            $this->service = new BrandService(
                new BrandStubRepository,
            );
        }
        return $this->service;
    }

    /**
     * Проверяем корректность создания и заполняемость репы
     *
     * @return void
     */
    public function testCreate()
    {
        $service = $this->getService();

        $bmw = $service->create('BMW');
        $this->assertNotNull($bmw->getId());
        $this->assertEquals(1, $bmw->getId());

        $audi = $service->create('Audi');
        $mers = $service->create('Mercedes-Benz');

        $brands = $service->find();
        $this->assertCount(3, $brands);
        $this->assertEquals($brands[1]->getId(), $bmw->getId());
        $this->assertEquals($brands[2]->getId(), $audi->getId());
        $this->assertEquals($brands[3]->getId(), $mers->getId());
    }
    
    /**
     * Создание с ошибками
     *
     * @return void
     */
    public function testCreateWithError()
    {
        $service = $this->getService();

        $this->expectException(CantCreateWihtoutName::class);
        $service->create('');
    }

    /**
     * Тест редактирования
     *
     * @return void
     */
    public function testUpdate()
    {
        $service = $this->getService();

        $mers = $service->create('Mercedes');
        $this->assertEquals($mers->name, 'Mercedes');

        $id = $mers->getId();
        $mers = $service->update($id, 'Mercedes-Benz');
        $this->assertEquals($mers->name, 'Mercedes-Benz');
        $this->assertEquals($mers->getId(), $id, 'После сохранения ид не совпадают');
    }

    /**
     * Тест удаления
     *
     * @return void
     */
    public function testDelete()
    {
        $service = $this->getService();
        
        $bmw = $service->create('BMW');
        $this->assertNotNull($id = $bmw->getId());

        $service->delete($id);

        $bmw = $service->findById($id);
        $this->assertNull($bmw);
    }
}