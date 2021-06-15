<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow;


use Symfony\Component\Workflow\SupportStrategy\WorkflowSupportStrategyInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class PalletSupportStrategyService implements WorkflowSupportStrategyInterface
{
    public function supports(WorkflowInterface $workflow, object $subject): bool
    {
        return true;
    }

}