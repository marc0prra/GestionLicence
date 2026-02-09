<?php

namespace App\Validator;

use App\Entity\CoursePeriod;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class CoursePeriodDateLimitValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CoursePeriodDateLimit) {
            throw new UnexpectedTypeException($constraint, CoursePeriodDateLimit::class);
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

        // extrait l'année depuis la date de début de l'année scolaire
        $yearReference = (int) $schoolYear->getStartDate()->format('Y');

        // dates limites
        $minLimit = new \DateTimeImmutable($yearReference . "-08-01 00:00:00");
        $maxLimit = new \DateTimeImmutable(($yearReference + 1) . "-07-31 23:59:59");

        // meme periode scolaire
        if ($start < $minLimit || $end > $maxLimit) {
            $this->context->buildViolation($constraint->message)
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