<?php
namespace Ath\MainBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Ath\MainBundle\Form\Model\FiltreSportAssociation;
use Doctrine\Common\Collections\ArrayCollection;

class FiltreAssociation
{
    protected $request;
    protected $em;
    protected $session;
    protected $container;

    public function __construct(Request $request, ObjectManager $em, Session $session, ContainerInterface $container)
    {
        $this->request = $request;
        $this->em      = $em;
        $this->session      = $session;
        $this->container = $container;
    }

    /**
     * filtre les associations
     * @return array(associations => Array of User (associations), filtreAssocModel => $filtreAssocModel)
     */
    public function filtreAssoc()
    {
        $paginator  = $this->container->get('knp_paginator');
        $keyword = array();
        $keyword["sports"]  = $this->getKeyword('sports');
        $page = $this->request->get('page');

        if ($page) {
            $keyword = $this->session->get('keyword');
        } 
        else // on met en session le tableau de filtre
        {
            $page = 1;
            $this->session->set('keyword', $keyword);
        }
        $filtreAssocModel = $this->filtreSportAssociationInstanciation($keyword);

        $associations = $this->em->getRepository('AthUserBundle:User')->getAssociationFiltre($keyword);
        $searchAssociations = $paginator->paginate($associations, (int) $page, 3);
        // aucun réultat
        if (empty($searchAssociations->getItems())) {
            $searchAssociations = $paginator->paginate($associations, 1, 3);
        }

        $tab = array('associations' => $searchAssociations, 'filtreAssocModel' => $filtreAssocModel);

        return $tab;
    }

    /**
     * Récupère la valeur en post de keyword
     */
    private function getKeyword($sufix)
    {
        $keyword = array();
        if ($this->request->getMethod() == "POST")
        {
            $filters = $this->request->request->get('sports_form_type');

            if (array_key_exists($sufix, $filters)) {
                $keyword     = $filters[$sufix];
            }
        }

        return $keyword;
    }

    /**
     * filtreSportAssociationInstanciation Instancie un objet FiltreSportAssociation à partir du tableau de filtre 
     * @param  Array $keyword tableau de filtre
     * @return filtreSportAssociation
     */
    private function filtreSportAssociationInstanciation($keyword) 
    {
        $filtreSportAssoc = new FiltreSportAssociation();
        $tabSports = new ArrayCollection();

        foreach ($keyword["sports"] as $oneSport) {
            $tabSports[] = $this->em->getRepository('AthMainBundle:Sport')->find($oneSport);
        }
        $filtreSportAssoc->setSports($tabSports);

        return $filtreSportAssoc;
    }
}