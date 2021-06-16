<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class WorkflowAvailablePlace extends Constraint
{
    public string $message = 'The place "{{ value }}" is not valid workflow or state machine place.';

    public function __construct(public string $markingProperty = 'marking', $options = null, array $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
