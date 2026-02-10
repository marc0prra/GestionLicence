<?php

namespace App\Validator;

use App\Entity\CoursePeriod;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CoursePeriodDateLimitValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value) {
            return;
        }

        $entity = $this->context->getObject();

        if (!$entity instanceof CoursePeriod) {
            return;
        }

        $start = $entity->getStartDate();
        $end = $entity->getEndDate();
        $schoolYear = $entity->getSchoolYearId();

        if (!$start || !$end || !$schoolYear) {
            return;
        }

        $yearReference = (int) $schoolYear->getStartDate()->format('Y');

        $minLimit = new \DateTimeImmutable(($yearReference - 1).'-08-01 00:00:00');
        $maxLimit = new \DateTimeImmutable(($yearReference + 1).'-07-31 23:59:59');

        if ($start < $minLimit || $end > $maxLimit) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{year_start}}', (string) ($yearReference - 1))
                ->setParameter('{{year_end}}', (string) ($yearReference + 1))
                ->atPath('start_date')
                ->addViolation();
        }

        if ($end <= $start) {
            $this->context->buildViolation('La date de fin doit être supérieure à la date de début.')
               ->atPath('end_date')
               ->addViolation();
        }
    }
}
