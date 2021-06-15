<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WarehouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource]
#[ORM\Entity(repositoryClass: WarehouseRepository::class)]
class Warehouse
{

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string')]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 4)]
    private string $id;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'warehouse', targetEntity: Package::class)]
    private $packages;

    #[Pure] public function __construct()
    {
        $this->packages = new ArrayCollection();
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): self
    {
        $this->packages->add($package);

        return $this;
    }
}
