<?php

namespace App\Domain;

use App\Domain\Helper\IdentifiedEntity;
use App\Domain\Helper\Nameable;
use Doctrine\ORM\Mapping as ORM;
/**
 * Модель авто
 * 
 * @ORM\Entity
 */
class Model extends Entity
{
    use IdentifiedEntity;
    use Nameable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    public Brand $brand;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    public function __construct(string $name, Brand $brand)
    {
        $this->setName($name);
        $this->brand = $brand;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'brand' => $this->brand,
            'name' => $this->name,
        ];
    }
}