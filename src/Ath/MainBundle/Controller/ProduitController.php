<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Ath\MainBundle\Form\Type\CategorieProduitFormType;

class ProduitController extends Controller
{
    /**
     * @Route("/associations", name="ath_list_association")
     */
    public function indexAction(Request $request, $page) {

        $form = $this->createForm(new CategorieProduitFormType());
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('AthMainBundle:Produit')->getProduitList($page,6);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $filtreCategorie = $data->categorieProduit;

                if (count($filtreCategorie) == 0) {
                    $searchProduits = $produits;
                }
                else // on a des categorie on filtre
                {
                    $searchProduits = $em->getRepository('AthMainBundle:Produit')->getCategorieProduitFiltre($filtreCategorie, $page,6);
                }

                $pagination = array(
                    'page' => $page,
                    'route' => 'ath_list_produit',
                    'pages_count' => ceil(count($searchProduits) / 6),
                    'route_params' => array()
                );

                return $this->render('@ath_views/Ath/Produit/index.html.twig', array(
                    'form' => $form->createView(),
                    'produits' => $searchProduits,
                    'pagination' => $pagination
                ));
            }
        } else {
            foreach ($produits as $produit) {
                $produit->getCategorieProduit();
            }
            $produits_count = $em->getRepository('AthMainBundle:Produit')->countProduit();
        }

        $pagination = array(
            'page' => $page,
            'route' => 'ath_list_produit',
            'pages_count' => ceil($produits_count / 6),
            'route_params' => array()
        );

        return $this->render('@ath_views/Ath/Produit/index.html.twig', array(
            'form' => $form->createView(),
            'produits' => $produits,
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/associations/{id}", name="ath_page_association")
     */
    public function pageAction($id) {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AthMainBundle:Produit')->getProduit($id);

        if ($produit) {
            $produit = $produit[0];
        }

        //$association->getUserFollow();

        return $this->render('@ath_views/Ath/Produit/page.html.twig', array(
            'produit' => $produit
        ));
    }
}