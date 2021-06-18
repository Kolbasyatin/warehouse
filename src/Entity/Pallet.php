<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Infrastructure\Workflow\PlaceableInterface;
use App\Infrastructure\Workflow\WorkflowNameMatcher;
use App\Repository\PalletRepository;
use App\Validator\WorkflowAvailablePlace;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource]
#[ORM\Entity(repositoryClass: PalletRepository::class)]
#[WorkflowAvailablePlace(markingProperty: 'currentPlace')]
class Pallet implements PlaceableInterface
{
    public const WORKFLOW_TYPES = [
        WorkflowNameMatcher::PALLET_WORKFLOW_TYPE_REGULAR,
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

    #[ORM\ManyToOne(targetEntity: Warehouse::class, inversedBy: 'packages' )]
    ##TODO: Валидатор на изменения warehouse только при отправке в другой склад или создание нового!!!
    private Warehouse $warehouse;


    public function getId(): ?int
    {
        return $this->id;
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
