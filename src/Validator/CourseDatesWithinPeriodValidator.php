<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\CoursePeriodRepository;

final class CourseDatesWithinPeriodValidator extends ConstraintValidator
{
    public function __construct(
        private CoursePeriodRepository $coursePeriodRepository
    ) {
    }
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var CourseDatesWithinPeriod $constraint */
        if (null === $value || '' === $value) {
            return;
        }

        $form = $this->context->getRoot();
        $start = $form->get($constraint->startField)->getData();
        $end = $form->get($constraint->endField)->getData();

        if (!$start instanceof \DateTimeInterface || !$end instanceof \DateTimeInterface) {
            return;
        }

        $period = $this->coursePeriodRepository->findPeriodByCourseDates($start, $end);

        if (!$period) {
            $this->context->buildViolation($constraint->message)
                ->atPath($constraint->endField)
                ->addViolation()
            ;
        }
    }
}
