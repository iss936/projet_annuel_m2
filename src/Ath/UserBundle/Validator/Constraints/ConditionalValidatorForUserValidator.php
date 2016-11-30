<?php

namespace Ath\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConditionalValidatorForUserValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        $statutId = $protocol->getStatutJuridiqueId();
        $prenom = $protocol->getPrenom();
        $dateDeCreation = $protocol->getDateDeCreation();
        $dateDeNaissance = $protocol->getDateDeNaissance();
      
        // on a une Association
        if ($statutId == 2)
        {
            if (empty($dateDeCreation))
            {
                $this->context->addViolationAt('dateDeCreation', 'Veuillez saisir la date de création de votre Association', array(), null);
            }
          
        }

        // On a un Homme ou une Femme
        if($statutId < 2)
        {
            if (empty($prenom))
            {
                $this->context->addViolationAt('prenom', $constraint->message, array(), null);
            }

            if (empty($dateDeNaissance))
            {
                $this->context->addViolationAt('dateDeNaissance', 'Veuillez saisir votre date de naissance', array(), null);
            }
        }
    }
}
