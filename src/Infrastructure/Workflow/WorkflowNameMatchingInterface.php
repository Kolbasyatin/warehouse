<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow;


interface WorkflowNameMatchingInterface
{
    public function match(PlaceableInterface $placeable): string|null;
}