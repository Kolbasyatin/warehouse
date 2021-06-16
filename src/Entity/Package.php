<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Infrastructure\Workflow\PlaceableInterface;
use App\Repository\PackageRepository;
use App\Validator\WorkflowAvailablePlace;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource]
#[ORM\Entity(repositoryClass: PackageRepository::class)]
#[WorkflowAvailablePlace(markingProperty: 'currentPlace')]
class Package implements PlaceableInterface
{
    public const PACKAGE_WORKFLOW_TYPE_REGULAR = 'regular';

    public const PACKAGE_WORKFLOW_TYPE_DELAY = 'delay';

    public const WORKFLOW_TYPES = [
        self::PACKAGE_WORKFLOW_TYPE_REGULAR,
        self::PACKAGE_WORKFLOW_TYPE_DELAY
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotNull(message: 'WorkflowPlace can not be null!')]
    private string $currentPlace;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(choices: self::WORKFLOW_TYPES, message: 'Package workflow type is not valid!')]
    #[Assert\NotNull]
    private string $workflowType;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\Type('string')]
    private string $fid;

    #[ORM\ManyToOne(targetEntity: Warehouse::class, inversedBy: 'packages' )]
    ##TODO: Валидатор на изменения warehouse только при отправке в другой склад или создание нового!!!
    private Warehouse $warehouse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFid(): string
    {
        return $this->fid;
    }

    public function setFid(string $fid): self
    {
        $this->fid = $fid;

        return $this;
    }

    public function getCurrentPlace(): ?string
    {
        return $this->currentPlace;
    }

    public function setCurrentPlace(string $currentPlace): self
    {
        $this->currentPlace = $currentPlace;

        return $this;
    }

    public function getWorkflowType(): string
    {
        return $this->workflowType;
    }

    public function setWorkflowType(string $workflowType): self
    {
        $this->workflowType = $workflowType;

        return $this;
    }

    public function getWarehouse(): Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }


}
