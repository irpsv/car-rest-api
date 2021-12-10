<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Domain\BodyType;
use App\Domain\BodyType\BodyTypeService;
use App\Domain\Brand\BrandService;
use App\Domain\Car\CarService;
use App\Domain\Model\ModelService;
use App\Domain\Modification\ModificationService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210181201 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getDescription(): string
    {
        return 'Генерация данных';
    }

    public function up(Schema $schema): void
    {
        $brandService = $this->container->get(BrandService::class);
        $bodyTypeService = $this->container->get(BodyTypeService::class);
        $modelService = $this->container->get(ModelService::class);
        $modificationService = $this->container->get(ModificationService::class);
        $carService = $this->container->get(CarService::class);

        $this->generateBodyType($bodyTypeService);
        $this->generateBrands($brandService);
        $this->generateModels($modelService, $brandService);
        $this->generateModifications($modificationService, $modelService);
        $this->generateCars($carService, $modificationService, $bodyTypeService);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("TRUNCATE TABLE car RESTART IDENTITY CASCADE");
        $this->addSql("TRUNCATE TABLE modification RESTART IDENTITY CASCADE");
        $this->addSql("TRUNCATE TABLE model RESTART IDENTITY CASCADE");
        $this->addSql("TRUNCATE TABLE brand RESTART IDENTITY CASCADE");
        $this->addSql("TRUNCATE TABLE body_type RESTART IDENTITY CASCADE");
    }

    private function generateBodyType(BodyTypeService $bodyTypeService)
    {
        $names = [
            "седан",
            "хетчбэк",
            "универсал",
            "кроссовер",
            "купе",
            "пикап",
        ];

        foreach ($names as $name) {
            $bodyTypeService->create($name);
        }
    }

    private function generateBrands(BrandService $brandService)
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
            $brandService->create($name);
        }
    }

    private function generateModels(ModelService $modelService, BrandService $brandService)
    {
        $brands = $brandService->getRepo()->getAll();
        $alphabet = 'ASDFGHJKLQWERTYUIOcvbnm1234567890';

        foreach ($brands as $brand) {
            $countModels = mt_rand(2,5);
            while ($countModels--) {
                $randomName = substr(str_shuffle($alphabet), 0, 5);
                $modelService->create($brand->getId(), $randomName);
            }
        }
    }

    private function generateModifications(ModificationService $modificationService, ModelService $modelService)
    {
        $models = $modelService->getRepo()->getAll();
        $currentYear = (int) date('Y');

        foreach ($models as $model) {
            $yearStart = mt_rand(1990, 2005);
            $max = mt_rand(1,3);

            for ($i=1; $i <= $max; $i++) {
                $yearEnd = $yearStart + mt_rand(3, 7);
                if ($yearStart > $currentYear || $yearEnd > $currentYear) {
                    break;
                }
                
                $modificationService->create($model->getId(), [
                    'name' => "{$i} поколение",
                    'productionYearStart' => $yearStart,
                    'productionYearEnd' => $yearEnd,
                ]);

                $yearStart = $yearEnd;
            }
        }
    }

    private function generateCars(CarService $carService, ModificationService $modificationService, BodyTypeService $bodyTypeService)
    {
        $modifications = $modificationService->getRepo()->getAll();

        /**
         * @var int[]
         */
        $bodyTypeIds = array_map(fn(BodyType $item) => $item->getId(), $bodyTypeService->getRepo()->getAll());

        foreach ($modifications as $modification) {
            shuffle($bodyTypeIds);
            $bodyTypeCount = mt_rand(1, count($bodyTypeIds));
            
            for ($i=0; $i < $bodyTypeCount; $i++) { 
                $bodyTypeId = $bodyTypeIds[$i];
                $yearProduction = mt_rand($modification->productionYearStart, $modification->productionYearEnd);

                $carService->create($modification->getId(), $bodyTypeId, $yearProduction);
            }
        }
    }
}
