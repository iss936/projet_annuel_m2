<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FileProduitAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $image = $this->getSubject();

        $id = $this->getRequest()->get($this->getIdParameter());
        
        $formMapper
            ->add('file', 'image', array(
            'data_class' => 'Symfony\Component\HttpFoundation\File\File',
            'label' => 'Image',
            'required' => false,
            'image_web_path' => ($id && is_object($image)) ? $this->getRequest()->getBasePath().'/'.$image->getWebPath() : ''// affiche
        ))
        ;
    }

     // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('produit')
            ->add('nomFichier', 'array', array('label'=>'Photo','template'=>'@ath_admin_path/Commun/image.html.twig'))

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
