<?php

declare(strict_types=1);


namespace App\Twig;


use App\Infrastructure\Workflow\PlaceableInterface;
use Symfony\Component\Workflow\Registry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WorkflowExtension extends AbstractExtension
{
    public function __construct(private Registry $workflowRegistry)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('workflow_all_transitions', [$this, 'getTransitions']),
            new TwigFunction('workflow_name', [$this, 'getCurrentWorkflowName']),
        ];
    }

    public function getTransitions($object, string $name = null): array
    {
        $workflow = $this->workflowRegistry->get($object, $name);

        return $workflow->getDefinition()->getTransitions();
    }

    public function getCurrentWorkflowName(PlaceableInterface $placeable): string
    {
        $workflow = $this->workflowRegistry->get($placeable);

        return $workflow->getName();
    }

}