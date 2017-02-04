<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ath\MainBundle\Form\Type\CategorieProduitFormType;

class ProduitController extends Controller
{
    public function indexAction(Request $request, $page) {
        $all = 'all';
        if ('POST' === $request->getMethod()) {
            if ($_POST['optradio'] != "all") {
                $all = $_POST['optradio'];
            }
        }

        $form = $this->createForm(new CategorieProduitFormType());
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('AthMainBundle:Produit')->getProduitList($page,6);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            $radioProduit = $request->request->get('optradio');
            if ($form->isValid()) {
                $data = $form->getData();
                $filtreCategorie = $data->categorieProduit;

                $comparateur = [];
                $comparateur['prix'] = $data->prix;
                if (count($filtreCategorie) != 0) {
                    $comparateur['categorieProduit'] = $filtreCategorie;
                }
                switch($radioProduit) {
                    case 'all' :
                            $searchProduits = $em->getRepository('AthMainBundle:Produit')->getCategorieProduitFiltre($comparateur, $page,6);
                        break;
                    case 'my' :
                        $user = $this->getUser();
                        $comparateur['myProduit'] = $em->getRepository('AthMainBundle:Produit')->getMyProducts($user);
                        $searchProduits = $em->getRepository('AthMainBundle:Produit')->getCategorieProduitFiltre($comparateur, $page,6);
                        break;
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
                    'pagination' => $pagination,
                    'seeAll' => $all
                ));
            }
        } else {
            foreach ($produits as $produit) {
                $produit->getCategorieProduit();
            }
        }

        $pagination = array(
            'page' => $page,
            'route' => 'ath_list_produit',
            'pages_count' => ceil(count($produits)/ 6),
            'route_params' => array()
        );

        return $this->render('@ath_views/Ath/Produit/index.html.twig', array(
            'form' => $form->createView(),
            'produits' => $produits,
            'pagination' => $pagination,
            'seeAll' => $all

        ));
    }

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