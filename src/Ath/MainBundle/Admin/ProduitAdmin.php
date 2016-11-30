<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProduitAdmin extends Admin
{

    private $em;

    protected $baseRoutePattern = 'produit';

    public function toString($object)
    {
        return  $object->getId()
            ? $object
            : 'Création d\' un produit'; // shown in the breadcrumb on the create view
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
            ->add('prix','array', array('template' => '@ath_admin_path/Commun/list_money.html.twig'))
            ->add('url','text', array('label' => "Lien d'achat",'template' => '@ath_admin_path/Commun/list_href.html.twig'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
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
            ->add('fileProduits', 'sonata_type_collection', array(
                'required' => false,
                'by_reference' => false,
                'label' => 'Photos'
            ), array(
                        'edit' => 'inline',
                        'inline' => 'table'
            ))
            ->add('prix')
            ->add('url','text', array('label' => "Lien d'achat"))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('libelle')
            ->add('description')
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('prix','array', array('template' => '@ath_admin_path/Commun/list_money.html.twig'))
            ->add('url','text', array('label' => "Lien d'achat"))
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

    public function prePersist($object)
    {
        $prix = str_replace(',', '.', $object->getPrix());
        $prix = number_format($prix,2);

        $object->setPrix($prix);
        
        foreach ($object->getFileProduits() as $image) {
           $image->setProduit($object);
        }

        return $object;
    }

    public function preUpdate($object)
    {
        $prix = str_replace(',', '.', $object->getPrix());
        $prix = number_format($prix,2);

        $object->setPrix($prix);
        
        foreach ($object->getFileProduits() as $image) {
           $image->setProduit($object);
        }
        return $object;
    }
}
