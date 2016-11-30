<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CommentAdmin extends Admin
{

    protected $baseRoutePattern = 'commentaire';

    public function toString($object)
    {
        return  $object->getId()
            ? $object->getId()
            : 'Création d\' un commentaire'; // shown in the breadcrumb on the create view
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('post')
            ->add('createdBy',null, array('label' => "Créé par"))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('createdBy',null, array('label' => "Créé par"))
            ->add('message', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
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
            ->add('post')
            ->add('message')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('createdBy',null, array('label' => "Créé par"))
            ->add('message')
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
        ;
    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();

        $object->setCreatedBy($user);

        return $object;
    }

    public function getExportFormats()
    {
        return array(
            // 'csv'
        );
    }
}
