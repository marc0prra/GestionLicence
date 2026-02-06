<?php

namespace App\Validator;

use App\Entity\Instructor;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class IntervenantHasModuleValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IntervenantHasModule) {
            throw new UnexpectedTypeException($constraint, IntervenantHasModule::class);
        }

        if (null === $value || empty($value)) {
            return;
        }

        $form = $this->context->getRoot();
        $module = $form->get($constraint->moduleField)->getData();

        if (!$module) {
            return;
        }

        foreach ($value as $instructor) {
            $isAssociated = $instructor->getInstructorModules()->exists(function ($key, $instructorModule) use ($module) {
                $linkedModule = $instructorModule->getModule();
                return $linkedModule && $linkedModule->getId() === $module->getId();
            });

            if (!$isAssociated) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
