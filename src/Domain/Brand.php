<?php

namespace App\Domain;

use App\Domain\Brand\BrandRepository;
use App\Domain\Exception\CantCreateWihtoutName;
use App\Domain\Helper\IdentifiedEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Бренд авто
 * 
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
{
    use IdentifiedEntity;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    public string $name;

    public function __construct(string $name)
    {
        $name = trim($name);
        if (empty($name)) {
            throw new CantCreateWihtoutName(get_called_class());
        }

        $this->name = $name;
    }
}