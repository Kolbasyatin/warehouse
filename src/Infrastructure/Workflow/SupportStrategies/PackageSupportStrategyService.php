<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow\SupportStrategies;


use App\Entity\Package;
use App\Infrastructure\Workflow\PlaceableInterface;
use Symfony\Component\Workflow\SupportStrategy\WorkflowSupportStrategyInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class PackageSupportStrategyService implements WorkflowSupportStrategyInterface
{
    public const PACKAGE_WORKFLOW_MAP = [
        Package::PACKAGE_WORKFLOW_TYPE_REGULAR => PlaceableInterface::REGULAR_PACKAGE_WORKFLOW_NAME,
        Package::PACKAGE_WORKFLOW_TYPE_DELAY => PlaceableInterface::DELAY_PACKAGE_WORKFLOW_NAME
    ];

    /**
     * @param WorkflowInterface $workflow
     * @param PlaceableInterface $subject
     */
    public function supports(WorkflowInterface $workflow, $subject): bool
    {
        $appropriateWorkflowName = self::PACKAGE_WORKFLOW_MAP[$subject->getWorkflowType()] ?? null;

        return $workflow->getName() === $appropriateWorkflowName;
    }
}