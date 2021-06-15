<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class WorkflowAvailablePlace extends Constraint
{
    public string $message = 'The place "{{ value }}" is not valid workflow or state machine place.';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
