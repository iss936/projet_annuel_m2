<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Ath\MainBundle\Form\Type\SportsFormType;

class AssociationController extends Controller
{
    /**
     * @Route("/associations", name="ath_list_association")
     */
    public function indexAction(Request $request, $page) {

        $form = $this->createForm(new SportsFormType());
        $em = $this->getDoctrine()->getManager();
        $sports = $em->getRepository('AthMainBundle:Sport')->getSportAll();

        $associations = $em->getRepository('AthUserBundle:User')->getAssociationList($page,6);


        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $searchAssociations = [];
                foreach ($associations as $association) {
                    foreach ($association->getAssociationSports() as $sport) {
                        if ($sport->getName() == $data->sports->getName()) {
                            $searchAssociations[] = $association;
                        }
                    }
                }

                $pagination = array(
                    'page' => $page,
                    'route' => 'ath_list_association',
                    'pages_count' => ceil(count($searchAssociations) / 6),
                    'route_params' => array()
                );

                return $this->render('@ath_views/Ath/Association/index.html.twig', array(
                    'form' => $form->createView(),
                    'associations' => $searchAssociations,
                    'sports' => $sports,
                    'pagination' => $pagination
                ));
            }
        } else {
            foreach ($associations as $association) {
                $association->getAssociationSports();
            }

            $association_count = $em->getRepository('AthUserBundle:User')->countAssociation();
        }


        $pagination = array(
            'page' => $page,
            'route' => 'ath_list_association',
            'pages_count' => ceil($association_count / 6),
            'route_params' => array()
        );

        return $this->render('@ath_views/Ath/Association/index.html.twig', array(
            'form' => $form->createView(),
            'associations' => $associations,
            'sports' => $sports,
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/associations/{id}", name="ath_page_association")
     */
    public function pageAction($id) {
        $em = $this->getDoctrine()->getManager();
        $association = $em->getRepository('AthUserBundle:User')->getAssociation($id);

        if ($association) {
            $association = $association[0];
        }

        //$association->getUserFollow();

        return $this->render('@ath_views/Ath/Association/page.html.twig', array(
            'association' => $association
        ));
    }
}