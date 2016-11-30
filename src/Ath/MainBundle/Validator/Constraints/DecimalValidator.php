<?php

namespace Ath\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DecimalValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {	
    	$prix = $protocol->getPrix();
		$prix = str_replace(",",".",$prix);
    	$protocol->setprix($prix);
        
    	if (!is_numeric($prix) && $prix != null)
    	{
    		$this->context->addViolationAt('prix', $constraint->message, array(), null);
    	}
    }
}
