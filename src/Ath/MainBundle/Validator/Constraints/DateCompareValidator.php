<?php

namespace Ath\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateCompareValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        $dateDebut = $protocol->getDateDebut();

        $dateFin = $protocol->getDateFin();

        if ($dateDebut != null && $dateFin != null)
        {
            if ($dateDebut > $dateFin)
            {
                $this->context->addViolationAt('dateDebut', $constraint->message, array(), null);
            }
            $now = new \DateTime();
            if ($dateFin < $now) {
                $this->context->addViolationAt('dateFin', 'La date de fin doit être dans le futur', array(), null);
            }
        }
    }
}
