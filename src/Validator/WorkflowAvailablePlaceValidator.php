<?php

namespace App\Validator;

use App\Infrastructure\Workflow\PlaceableInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Workflow\Registry;

class WorkflowAvailablePlaceValidator extends ConstraintValidator
{
    public function __construct(private Registry $registry)
    {
    }

    /** @var PlaceableInterface $value */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof WorkflowAvailablePlace) {
            throw new UnexpectedTypeException($constraint, WorkflowAvailablePlace::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof PlaceableInterface) {
            throw new UnexpectedValueException($value, PlaceableInterface::class);
        }

        $workflows = $this->registry->all($value);
        $workflow = $this->registry->get($value);

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
