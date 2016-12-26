<?php

namespace Ath\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Decimal extends Constraint
{
    public $message = 'Veuillez saisir un nombre';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
