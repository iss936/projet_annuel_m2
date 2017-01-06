<?php

namespace Ath\MainBundle\EventListener;

use Ath\MainBundle\Entity\UserFollow;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\Persistence\ObjectManager;

class UserFollowIndexer
{
    private $container;
    private $userFollow;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->userFollow = null;
    }


    /**
    * Creation
    *
    **/
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof UserFollow) {
            $destinataire = $entity->getUserDestinataire();
            if ($destinataire->getUserSetting()->getAutoFollow() == 1) {
                $entity->setAccepte(1);
            }
            else {
                //senMail x veut vous suivre
            }

            if ($destinataire->getUserSetting()->getMailWhenFollower() == 1) {
             // $this->container->get('atix_main.services.send_mail')->congesAValider($user, $this->demandeConge);
            }
            else{
                // on fait rien
            }
        }
    }

    /**
    * Modification
    *
    **/
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof UserFollow) {
            $this->userFollow = $entity;
            if ($this->userFollow->getAccepte() == 1) {
                // sendMail Invitation Accepté
            }
            elseif ($this->userFollow->getAccepte() == 0) {
                // sendMail Invitation Refusé
            }
        }
    }

    /**
    * On envoie un email
    *
    **/
    public function postFlush(PostFlushEventArgs $event)
    {
        if ($this->userFollow != null) {
            $em = $event->getEntityManager();
             // $this->container->get('atix_main.services.send_mail')->congesAValider($user, $this->demandeConge);
            
        }
    }   


}
