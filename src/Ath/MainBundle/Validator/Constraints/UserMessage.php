<?php

namespace Ath\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserMessage extends Constraint
{
    public $message = 'l\'émetteur et le destinataire doivent faire partie de la discution';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
