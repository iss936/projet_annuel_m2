<?php

namespace Ath\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserMessageValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {	
    	$userDiscussion = $protocol->getUserDiscussion();
        $tabInterlocuteurs = array($userDiscussion->getUserEmetteur()->getId(),$userDiscussion->getUserDestinataire()->getId());

        $emetteurId = $protocol->getUserEmetteur()->getId();
        $destinataireId = $protocol->getUserDestinataire()->getId();

        if (!in_array($emetteurId, $tabInterlocuteurs) || !in_array($destinataireId, $tabInterlocuteurs))
        {
            $this->context->addViolationAt('userDiscussion', $constraint->message, array(), null);
        }

        if($emetteurId == $destinataireId)
            $this->context->addViolationAt('userDestinataire', "Le destinataire doit être différent de l'émetteur", array(), null);

    }
}
