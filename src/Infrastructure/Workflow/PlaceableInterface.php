<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow;


interface PlaceableInterface
{
    public function getCurrentPlace();

    public function getWorkflowType();
}