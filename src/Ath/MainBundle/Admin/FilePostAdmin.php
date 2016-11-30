<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FilePostAdmin extends Admin
{

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nomFichier')
            ->add('typeFichier')
            ->add('originalFichier')
            ->add('createdAt')
            ->add('updatedAt')
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
        // get the current Image instance
        $image = $this->getSubject();

        $id = $this->getRequest()->get($this->getIdParameter());
        
        $formMapper
            ->add('file', 'image', array(
            'data_class' => 'Symfony\Component\HttpFoundation\File\File',
            'label' => 'Photo',
            'required' => false,
            'image_web_path' => ($id && is_object($image)) ? $this->getRequest()->getBasePath().'/'.$image->getWebPath() : ''// affiche
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
            ->add('nomFichier')
            ->add('typeFichier')
            ->add('originalFichier')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
