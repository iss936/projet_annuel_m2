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
    **/
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof UserFollow) {
            $emetteur = $entity->getUserEmetteur();
            $destinataire = $entity->getUserDestinataire();
            
            if ($destinataire->getUserSetting()->getAutoFollow() == 1) {
                $entity->setAccepte(1);
                $entity->setDateReponse(new \DateTime());
            }
            else {
                //senMail x veut vous suivre
            }
            
            if ($destinataire->getUserSetting()->getMailWhenFollower() == 1) {
                $requestStack = $this->container->get('request_stack');
                $masterRequest = $requestStack->getMasterRequest(); // this is the call that breaks ESI

                if ($masterRequest) {
                    $this->container->get('ath_main.services.send_mail')->suivreUser($emetteur, $destinataire);
                }
            }
            else{
                // on fait rien
            }
            $entity->setDateDemande(new \DateTime());
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
            $entity->setDateReponse(new \DateTime());
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
