<?php

namespace Ath\UserBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RoleRegisterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SUBMIT => 'setRole');
    }

    public function setRole(FormEvent $event)
    {
        $aRoles = array('ROLE_USER','ROLE_ASSOC');

        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
        if($user->getStatutJuridiqueId() == 2)
            $user->setRoles($aRoles);
        else
            $user->addRole('ROLE_USER');
   }
}