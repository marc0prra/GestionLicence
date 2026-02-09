<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class IntervenantHasModule extends Constraint
{
    public string $moduleField = 'module_id';
    public string $message = 'L\'intervenant n\'est pas rattaché à ce module';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
