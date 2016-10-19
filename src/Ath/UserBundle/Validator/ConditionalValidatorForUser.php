<?php

namespace Ath\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConditionalValidatorForUser extends Constraint
{
    public $message = 'Veuillez saisir votre prénom ';
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public function validatedBy()
    {
        return 'post_registration_validation';
    }

}
