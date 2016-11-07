<?php

namespace Ath\MainBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * SendMail.php
 * 
 * Permet d'envoyer les mails
 *
 */
class SendMail
{

    private $container;
    private $em;
    private $from; // voir parameters.yml

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, EntityManager $em)
    {
        $this->container = $container;
        $this->from = $this->container->getParameter('email_from');
        $this->em = $em;
    }

    /**
     * Permet d'envoyer un mail pour valider l'inscription depuis un réseau social
     *
     * @param User $user
     */
    public function registrationBySocialNetwork($user)
    {
        $trad = $this->container->get('translator');
        $subject = $trad->trans(
            "registration.email.subject",
            array('%username%' => $user->getNomComplet()),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($user->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_registration_since_social_network.html.twig',
                array(
                    'user' => $user,
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
        $this->container->get('session')->getFlashBag()->add('notice', $trad->trans("registration.flash.mail_send", array(), 'mail'));
    }


    /**
     * Permet d'envoyer un mail afin de faire une demande célébrité aux administrateurs
     *
     * @param User $user, string $message
     */
    public function demandeCelebrite($user,$message)
    {
        $trad = $this->container->get('translator');
        $subject = $trad->trans(
            "demande_celebrite.email.subject",
            array('%id%' => $user->getId()),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($user->getEmail())
            ->setTo($this->from);

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_demande_celebrite.html.twig',
                array(
                    'user' => $user,
                    'message' => $message
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }
}