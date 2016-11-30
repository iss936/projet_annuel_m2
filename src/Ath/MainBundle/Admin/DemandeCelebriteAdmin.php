<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class DemandeCelebriteAdmin extends Admin
{
    private $em;

    protected $baseRoutePattern = 'demande-celebrite';

    public function toString($object)
    {
        return  $object->getId()
            ? $object->getId()
            : 'Création d\' une demande de célébrité'; // shown in the breadcrumb on the create view
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('isAccepte')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('contenu')
            ->add('isAccepte')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('dateDemande')
            ->add('dateReponse')
            ->add('_action', 'actions', array(
                'actions' => array(
                    // 'edit' => array(),
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
            ->add('contenu')
            ->add('isAccepte')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
   /* protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('contenu')
            ->add('isAccepte')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('dateDemande')
            ->add('dateReponse')
        ;
    }*/
}
