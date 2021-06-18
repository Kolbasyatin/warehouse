<?php

declare(strict_types=1);


namespace App\Twig;


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
        ];
    }

    public function getTransitions($object, string $name = null): array
    {
        $workflow = $this->workflowRegistry->get($object, $name);

        return $workflow->getDefinition()->getTransitions();
    }

}