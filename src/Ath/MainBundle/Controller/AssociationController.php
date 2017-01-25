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
                $filtreSports = $data->sports;

                if (count($filtreSports) == 0) {
                    $searchAssociations = $associations;
                }   
                else // on a des sports on filtre
                {
                    $searchAssociations = $em->getRepository('AthUserBundle:User')->getAssociationFiltre($filtreSports, $page,6);
                }

               /* $searchAssociations = [];
                foreach ($associations as $association) {
                    foreach ($association->getAssociationSports() as $sport) {
                        if ($sport->getName() == $data->sports->getName()) {
                            $searchAssociations[] = $association;
                        }
                    }
                }*/

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
        $association = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $associationToShow = $em->getRepository('AthUserBundle:User')->getAssociation($id);

        if ($associationToShow) {
            $associationToShow = $associationToShow[0];
        }

        $followers =  $em->getRepository('AthUserBundle:User')->getLastFollowers($associationToShow);

        $countFollowers = $em->getRepository('AthUserBundle:User')->countFollowers($associationToShow);

        $amiFollows = $em->getRepository('AthUserBundle:User')->getAmiFollows($association);
        
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $association,
            'userToShow' => $associationToShow,
            'followers' => $followers,
            'amiFollows' => $amiFollows,
            'countFollowers' => $countFollowers
        ));

    }
}