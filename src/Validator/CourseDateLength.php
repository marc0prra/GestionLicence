<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class CourseDateLength extends Constraint
{
    public string $startField = 'start_date';
    public string $endField = 'end_date';
    public string $message = 'L\'intervention ne doit pas dépasser 4 heures.';
    public function __construct(
        public string $mode = 'strict',
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct([], $groups, $payload);
    }
}
