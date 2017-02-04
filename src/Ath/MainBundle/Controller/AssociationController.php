<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ath\MainBundle\Form\Type\SportsFormType;

class AssociationController extends Controller
{
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $formHandler = $this->container->get('ath.form.filtre_association');
        $tab = $formHandler->filtreAssoc();
        // injecte les valeurs par défaut dans le formulaire grâce au second paramètre
        $form = $this->createForm(new SportsFormType(), $tab['filtreAssocModel']);

        return $this->render('@ath_views/Ath/Association/index.html.twig', array(
            'form' => $form->createView(),
            'associations' => $tab['associations'],
        ));
    }

}