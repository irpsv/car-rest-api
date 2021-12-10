<?php

namespace App\Domain;

use App\Domain\Helper\IdentifiedEntity;
use App\Domain\Helper\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Бренд авто
 * 
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand extends Entity
{
    use IdentifiedEntity;
    use Nameable;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->name,
        ];
    }
}