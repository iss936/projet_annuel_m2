<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CategorieProduitAdmin extends Admin
{

    private $em;

    protected $baseRoutePattern = 'categorie/produit';

    public function toString($object)
    {
        return  $object->getId()
            ? $object
            : 'Création d\' une catégorie de produit'; // shown in the breadcrumb on the create view
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('libelle')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('libelle')
            ->add('description', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle')
            ->add('description')
        ;
    }

    public function getExportFormats()
    {
        return array(
            'csv'
        );
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

}
