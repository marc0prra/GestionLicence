<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CourseDateLengthValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var CourseDateLength $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $form = $this->context->getRoot();

        $start_date = $form->get($constraint->startField)->getData();
        $end_date = $form->get($constraint->endField)->getData();

        if (!$start_date instanceof \DateTimeInterface || !$end_date instanceof \DateTimeInterface) {
            return;
        }

        $interval = $start_date->diff($end_date);

        if (1 === $interval->invert) {
            $this->context->buildViolation('La date de fin ne peut pas être antérieure au début.')
                ->atPath($constraint->endField)
                ->addViolation();

            return;
        }

        if ($interval->days > 0 || $interval->h > 4 || (4 === $interval->h && $interval->i > 0)) {
            $this->context->buildViolation($constraint->message)
                ->atPath($constraint->endField)
                ->addViolation();
        }
    }
}
