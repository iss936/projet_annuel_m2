<?php

namespace Ath\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateCompare extends Constraint
{
    public $message = 'La date de début doit être inférieure à la date de fin';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
