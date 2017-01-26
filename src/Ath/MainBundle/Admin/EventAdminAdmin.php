<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EventAdminAdmin extends Admin
{
    protected $baseRoutePattern = 'evenement-admin';

    public function toString($object)
    {
        return  $object->getId()
            ? $object
            : 'Création d\' un évènement sportif'; // shown in the breadcrumb on the create view
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
            ->add('libelle')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('photoId','array', array('label' => "Photo",'template' => '@ath_admin_path/Commun/image.html.twig'))
            ->add('libelle')
            ->add('description', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
            ->add('dateDebut', 'array', array('label' => "Date de début", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('dateFin', 'array', array('label' => "Date de fin", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('siteWeb')
            ->add('themeSports', null, array('label' => 'Sports concernés'))
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
        $event = $this->getSubject();
        $id = $this->getRequest()->get($this->getIdParameter());

        $formMapper
            ->add('file', 'image', array(
                'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                'label' => 'Photo',
                'required' => ($id) ? false : true,
                'image_web_path' => ($id && is_object($event)) ? $this->getRequest()->getBasePath().'/'.$event->getWebPath() : ''// affiche
            ))
            ->add('libelle')
            ->add('description')
            ->add('dateDebut', 'sonata_type_datetime_picker', array(
                   'dp_language' => 'fr',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'attr' => array(
                      'data-date-format' => 'DD/MM/YYYY HH:mm',
            )))
            ->add('dateFin', 'sonata_type_datetime_picker', array(
                    'dp_language' => 'fr',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'attr' => array(
                      'data-date-format' => 'DD/MM/YYYY HH:mm',
            )))
            ->add('siteWeb')
            ->add('themeSports', null, array('label' => 'Sports concernés par l\'évènement'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
  /*  protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('file', 'array', array(
                'label' => "Photo",
                'template' => '@ath_admin_path/Commun/show_image.html.twig'
            ))
            ->add('libelle')
            ->add('description')
            ->add('dateDebut', 'date', array('label' => "Date de début", 'date_format' => 'dd/mm/YYYY HH:mm'))
            ->add('dateFin', null, array('label' => 'Date de fin'))
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('siteWeb')
        ;
    }*/

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();

        $object->setCreatedBy($user);

        return $object;
    }

    public function preUpdate($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();

        $object->setUpdatedBy($user);
        
        return $object;
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
}
 