<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow;


interface PlaceableInterface
{
    public const REGULAR_PACKAGE_WORKFLOW_NAME = 'regular_package';

    public const DELAY_PACKAGE_WORKFLOW_NAME = 'delay_package';

    public function getCurrentPlace();

    public function getWorkflowType();
}