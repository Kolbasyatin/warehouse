<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow\SupportStrategies;


use App\Infrastructure\Workflow\PlaceableInterface;
use App\Infrastructure\Workflow\WorkflowNameMatchingInterface;
use Symfony\Component\Workflow\SupportStrategy\WorkflowSupportStrategyInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class PlaceableSupportStrategyService implements WorkflowSupportStrategyInterface
{
    public function __construct(private WorkflowNameMatchingInterface $nameMatcher)
    {
    }

    public function supports(WorkflowInterface $workflow, $subject): bool
    {
        if (!$subject instanceof PlaceableInterface) {
            return false;
        }

        $appropriateWorkflowName = $this->nameMatcher->match($subject);

        return $workflow->getName() === $appropriateWorkflowName;
    }
}