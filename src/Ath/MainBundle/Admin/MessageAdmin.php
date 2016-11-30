<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MessageAdmin extends Admin
{
    private $em;

    protected $baseRoutePattern = 'message';

    public function toString($object)
    {
        return  $object->getId()
            ? $object->getId()
            : 'Création d\' un message'; // shown in the breadcrumb on the create view
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        // $collection->remove('create');
        // $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('userDiscussion',null, array('label' => "Id discution"))
            ->add('lu', 'doctrine_orm_choice', array('label' => 'Lu',
                    'field_options' => array(
                        'required' => false,
                        'choices' => array("1" => "Oui","0" => "Non")
                    ),
                    'field_type' => 'choice'
                ))
            ->add('userEmetteur')
            ->add('userDestinataire')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('userDiscussion',null, array('label' => "Id discution"))
            ->add('userEmetteur', 'text', array('label' => 'Emetteur'))
            ->add('userDestinataire', 'text', array('label' => 'Destinataire'))
            ->add('texte', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
            ->add('lu')
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
            ->add('userEmetteur',null, array('label' => "Emetteur", 'required' => true))
            ->add('userDestinataire', null, array('label' => "Destinataire", 'required' => true))
            ->add('userDiscussion',null, array('label' => "Id discution", 'required' => true))
            ->add('texte')
        ;
    }

    public function getExportFormats()
    {
        return array(
            'csv'
        );
    }

}
