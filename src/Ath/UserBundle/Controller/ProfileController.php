<?php

namespace Ath\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Ath\UserBundle\Form\EditProfileAssocType;
use Ath\UserBundle\Form\EditProfileType;

class ProfileController extends BaseController
{
     /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if($user->getStatutJuridiqueId() == 2)
            $form = $this->createForm(new EditProfileAssocType(), $user);
        else
            $form = $this->createForm(new EditProfileType(), $user);

        $formHandler = $this->container->get('ath.user.form.handler.edit_profile');
        
        // Enregistrement des modifications + setflash
        $formHandler->process($form);

        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}