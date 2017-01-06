<?php

namespace Ath\UserBundle\EventListener;

use Ath\MainBundle\Entity\UserSetting;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Ath\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserIndexer
{
    private $container;
    private $user;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->user = null;
    }


    /**
    * Creation
    *
    **/
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof User) {
            $entity->setSlug(uniqid(rand(), true));
            
            $userSetting = new UserSetting();
            $entity->setUserSetting($userSetting);

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
        if ($entity instanceof User) {
        }
    }

    /**
    *
    **/
    public function postFlush(PostFlushEventArgs $event)
    {
       
    }

}
