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
     * @param User $user, string $messageDemande
     */
    public function demandeCelebrite($user, $destinataire, $messageDemande)
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
            ->setTo($destinataire->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_demande_celebrite.html.twig',
                array(
                    'user' => $user,
                    'destinataire' => $destinataire,
                    'message' => $messageDemande
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }

    /**
     * Permet de confirmer la validation d'une demande de célébrité
     *
     * @param demandeCelebrite $demandeCelebrite
     */
    public function validationDemandeCelebrite($demandeCelebrite)
    {
        $trad = $this->container->get('translator');
        $user = $demandeCelebrite->getCreatedBy();
        $subject = $trad->trans(
            "demande_celebrite_validation.email.subject",
            array(),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($user->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_validation_demande_celebrite.html.twig',
                array(
                    'user' => $user,
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }

    /**
     * Permet de confirmer refuser une demande de célébrité
     *
     * @param demandeCelebrite $demandeCelebrite
     */
    public function refusDemandeCelebrite($demandeCelebrite)
    {
        $trad = $this->container->get('translator');
        $user = $demandeCelebrite->getCreatedBy();
        $subject = $trad->trans(
            "demande_celebrite_refus.email.subject",
            array(),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($user->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_refus_demande_celebrite.html.twig',
                array(
                    'user' => $user,
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }


    /**
     * Permet d'informer le group valideur de la validation d'une demande de célébrité
     *
     * @param demandeCelebrite $demandeCelebrite, User $destinataire
     */
    public function validationDemandeCelebriteForValideur($demandeCelebrite,$destinataire)
    {
        $trad = $this->container->get('translator');
        $user = $demandeCelebrite->getCreatedBy();
        $subject = $trad->trans(
            "demande_celebrite.email.subject",
            array("%id%" => $demandeCelebrite->getCreatedBy()->getId()),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($destinataire->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_validation_demande_celebrite_for_valideur.html.twig',
                array(
                    'destinataire' => $destinataire,
                    'demandeCelebrite' => $demandeCelebrite
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }

    /**
     * Permet d'informer le group valideur du refus d'une demande de célébrité
     *
     * @param demandeCelebrite $demandeCelebrite, User $destinataire
     */
    public function refusDemandeCelebriteForValideur($demandeCelebrite,$destinataire)
    {
        $trad = $this->container->get('translator');
        $user = $demandeCelebrite->getCreatedBy();
        $subject = $trad->trans(
            "demande_celebrite.email.subject",
            array("%id%" => $demandeCelebrite->getCreatedBy()->getId()),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($destinataire->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_refus_demande_celebrite_for_valideur.html.twig',
                array(
                    'destinataire' => $destinataire,
                    'demandeCelebrite' => $demandeCelebrite
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }

    /**
     * Permet d'informer un user qu'un autre user suis ses actualités
     *
     * @param User $userEmetteur, User $userDestinataire
     */
    public function suivreUser($userEmetteur,$userDestinataire)
    {
        $trad = $this->container->get('translator');

        $subject = $trad->trans(
            "user.nouveau.suivi",
            array("%user%" => $userEmetteur),
            'mail'
        );

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($userDestinataire->getEmail());

        $message->setBody(
            $this->container->get('templating')->render(
                '::Ath/Mail/mail_new_follower.html.twig',
                array(
                    'userDestinataire' => $userDestinataire,
                    'userEmetteur' => $userEmetteur
                )
            )
        )
        ->setContentType('text/html');

        $this->container->get('mailer')->send($message);
    }

}