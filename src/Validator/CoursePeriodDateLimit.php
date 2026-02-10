<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
final class CoursePeriodDateLimit extends Constraint
{
    public string $message = 'La période de cours doit être comprise entre le 01/08/{{year_start}} et le 31/07/{{year_end}}.';

    public function __construct(
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }
}
