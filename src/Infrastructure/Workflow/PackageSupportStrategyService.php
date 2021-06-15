<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow;


use App\Entity\Package;
use Symfony\Component\Workflow\SupportStrategy\WorkflowSupportStrategyInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class PackageSupportStrategyService implements WorkflowSupportStrategyInterface
{

    public const PACKAGE_WORKFLOW_MAP = [
        Package::WORKFLOW_TYPE_REGULAR => PlaceableInterface::REGULAR_PACKAGE_WORKFLOW_NAME,
        Package::WORKFLOW_TYPE_DELAY => PlaceableInterface::DELAY_PACKAGE_WORKFLOW_NAME
    ];

    /**
     * @param WorkflowInterface $workflow
     * @param PlaceableInterface $subject
     */
    public function supports(WorkflowInterface $workflow, $subject): bool
    {
        return true;
    }

}