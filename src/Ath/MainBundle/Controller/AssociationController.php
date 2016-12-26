<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AssociationController extends Controller
{
    /**
     * @Route("/associations", name="ath_list_association")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $associations = $em->getRepository('AthUserBundle:User')->getAssociationAll();

        return $this->render('@ath_views/Ath/Association/index.html.twig', array(
            'associations' => $associations
        ));
    }
}