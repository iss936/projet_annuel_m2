<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends Admin
{

    protected $baseRoutePattern = 'article';

    public function toString($object)
    {
        return  $object->getId()
            ? $object->getId()
            : 'Création d\' un Article'; // shown in the breadcrumb on the create view
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('createdBy',null, array('label' => 'Créé par'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('filePosts', 'array', array('label' => "Photo",'template' => '@ath_admin_path/Commun/article_first_image.html.twig'))
            ->add('createdBy',null, array('label' => 'Créé par'))
            ->add('contenu', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
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
            ->add('contenu')
            ->add('filePosts', 'sonata_type_collection', array(
                'required' => false,
                'by_reference' => false,
                'label' => 'Photos'
            ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('contenu')
            ->add('createdBy',null, array('label' => 'Créé par'))
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('filePosts','array', array('label' => "Photos",'template' => '@ath_admin_path/Commun/collection_post_images.html.twig'))
        ;
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

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $object->setCreatedBy($user);

        foreach ($object->getFilePosts() as $image) {
           $image->setPost($object);
        }
        return $object;
    }

    public function preUpdate($object)
    {
        foreach ($object->getFilePosts() as $image) {
           $image->setPost($object);
        }

        return $object;
    }
}
