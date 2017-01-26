<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GroupApplicationAdmin extends Admin
{
    protected $baseRoutePattern = 'groups';
    protected $em;

    public function toString($object)
    {
        return $object->getLibelle()
            ? $object->getLibelle()
            : 'Création d\' un groupe'; // shown in the breadcrumb on the create view
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('libelle')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('libelle')
            ->add('description')
            ->add('users', null, array('label' => 'Utilisateurs'))
            ->add('roles')
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
            ->add('users', null, array('label' => 'Utilisateurs'))
            ->add('roles', 'roles_app');
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('libelle')
            ->add('description')
            ->add('users')
            ->add('roles')
        ;
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

     public function getExportFormats()
    {
        return array(
            'xls'
        );
    }

    public function getDataSourceIterator()
    {
        $datasourceit = parent::getDataSourceIterator();
        $datasourceit->setDateTimeFormat('d/m/Y H:i'); //change this to suit your needs
        return $datasourceit;
    }

 /*   public function prePersist($object)
    {
        $users = $object->getUsers();

        $roles = $object->getRoles();

        foreach ($roles as $oneRole) {
            foreach ($users as $oneUser) {
                $oneUser->addRole($oneRole);
            }
        }

        return $object;
    }

    public function preUpdate($object)
    {
        $users = $object->getUsers();

        $roles = $object->getRoles();

        foreach ($roles as $oneRole) {
            foreach ($users as $oneUser) {
                $oneUser->addRole($oneRole);
            }
        }
        return $object;
    }*/
}
