<?php

namespace Ath\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Ath\UserBundle\Form\EditProfileAssocType;
use Ath\UserBundle\Form\EditProfileType;
use Ath\MainBundle\Form\Type\DemandeCelebriteFormType;
use Ath\MainBundle\Entity\DemandeCelebrite;

class ProfileController extends BaseController
{
     /**
     * Show the user
     */
   /* public function showAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userToShow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);
        
        // if (!is_object($user) || !$user instanceof UserInterface) {
        //     throw new AccessDeniedException('This user does not have access to this section.');
        // }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'userToShow' => $userToShow
        ));

    }*/

    public function showProfileAction(Request $request, $slug)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userToShow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);
        
        // if (!is_object($user) || !$user instanceof UserInterface) {
        //     throw new AccessDeniedException('This user does not have access to this section.');
        // }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'userToShow' => $userToShow
        ));
    }
    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if($user->getStatutJuridiqueId() == 3)
            $form = $this->createForm(new EditProfileAssocType(), $user);
        else
            $form = $this->createForm(new EditProfileType(), $user);

        $formHandler = $this->container->get('ath.user.form.handler.edit_profile');
        
        // Enregistrement des modifications + setflash
        $formHandler->process($form);

        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'canDemandeCelebrite' => $user->canDemandeCelebrite()
        ));
    }

    public function removePhotoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $trad = $this->container->get('translator');

        $user = $this->getUser();

        $user->removePhoto();

        $user->setPhotoId(null);
        $user->setPhotoExtension(null);
        $user->setPhotoOriginalName(null);

        $em->persist($user);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', $trad->trans("profile.flash.photoSupprimer", array(), 'home'));

        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    public function demandeCelebriteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if (!$user->canDemandeCelebrite()) {
            return $this->redirect($this->generateUrl('fos_user_profile_edit'));
        }
        $demandeCelebrite = new DemandeCelebrite();
        $demandeCelebrite->setCreatedBy($user);

        $form = $this->createForm(new DemandeCelebriteFormType(), $demandeCelebrite);

        $formHandler = $this->container->get('ath.form.handler.demande_celebrite');
        if($formHandler->process($form))
        {
            $sendMail = $this->container->get('ath_main.services.send_mail');
            $groups = $em->getRepository('AthMainBundle:GroupApplication')->findAll();
            $aUser = array();
            foreach ($groups as $group) {
                foreach ($group->getUsers() as $utilisateur) {
                    if ($utilisateur != $user && !array_key_exists($utilisateur->getId(), $aUser)) {
                        if ($utilisateur->hasRole('ROLE_ADMIN_DEMANDE_CELEBRITE')) {
                            $aUser[$utilisateur->getId()] = $utilisateur;
                        }
                    }
                }
            }
            foreach ($aUser as $oneUser) {
                $sendMail->demandeCelebrite($user,$oneUser, $form->getData()->getContenu());
            }
            // $sendMail->demandeCelebrite($user, $form->getData()->getContenu());
            return $this->redirect($this->generateUrl('fos_user_profile_edit'));
        }

        return $this->render('@ath_user_path/demande_celebrite.html.twig', array(
            'form' => $form->createView()
        ));
    }
}