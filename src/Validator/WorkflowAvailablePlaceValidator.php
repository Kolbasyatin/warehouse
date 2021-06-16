<?php

namespace App\Validator;

use App\Infrastructure\Workflow\PlaceableInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\LogicException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Workflow\Registry;

/**
 * По факту это задача логики спрашивать can у workflow, но на случай
 * подмены WF стоит лишний раз проверить на наличие места для перехода.
 */
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

        $workflow = $this->registry->get($value);
        $places = $workflow->getDefinition()->getPlaces();
        $currentPlace = $this->getCurrentMarking($value, $constraint);

        if (!in_array($currentPlace, $places)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $currentPlace)
                ->addViolation();
        }


    }

    private function getCurrentMarking($value, WorkflowAvailablePlace $constraint): string
    {
        $method = 'get'.ucfirst($constraint->markingProperty);

        if (!method_exists($value, $method)) {
            throw new LogicException(sprintf('The method "%s::%s()" does not exist.', get_debug_type($value), $method));
        }

        return $value->{$method}();
    }
}
