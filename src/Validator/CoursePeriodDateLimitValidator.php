<?php

namespace App\Validator;

use App\Entity\CoursePeriod;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

// App/Validator/CoursePeriodDateLimitValidator.php

// ... (imports existants)

final class CoursePeriodDateLimitValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        // ... (votre code de vérification du type reste identique jusqu'ici) ...

        $entity = $this->context->getObject();
        // ... (vérifications entity, start, end, schoolYear restent identiques) ...
        
        $start = $entity->getStartDate(); //
        $end = $entity->getEndDate();     //
        $schoolYear = $entity->getSchoolYearId(); //

        if (!$start || !$end || !$schoolYear) {
            return;
        }

        // On garde votre logique pour l'année de référence
        $yearReference = (int) $schoolYear->getStartDate()->format('Y'); //

        $minLimit = new \DateTimeImmutable($yearReference . "-08-01 00:00:00");
        $maxLimit = new \DateTimeImmutable(($yearReference + 1) . "-07-31 23:59:59");

        // C'EST ICI QU'ON MODIFIE LA CRÉATION DE L'ERREUR
        if ($start < $minLimit || $end > $maxLimit) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ year_start }}', (string) $yearReference)       // Remplace {{ year_start }}
                ->setParameter('{{ year_end }}', (string) ($yearReference + 1))   // Remplace {{ year_end }}
                ->atPath('start_date')
                ->addViolation();
        }

        // ... (le reste pour la date de fin > début reste identique)
        if ($end <= $start) {
             $this->context->buildViolation('La date de fin doit être supérieure à la date de début.')
                ->atPath('end_date')
                ->addViolation();
        }
    }
}