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

    /**
     * [configure permet de charger le js et le css nécessaire pour les pages create/edit/list]
     * @return Void
     */
    public function configure() {
        $this->setTemplate('list', '@ath_admin_path/Commun/list_demande_celebrite_javascript.html.twig');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
        $collection->add('reponse_demande_celebrite', $this->getRouterIdParameter().'reponse/demande-celebrite');
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('statut', null, array('required' => false), 'statuts_demande_celebrite_widget')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('createdBy', 'text', array('label' => "Créé par"))
            ->add('contenu', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
            ->add('statut', 'text', array('label' => "Statut", 'template'=> '@ath_admin_path/Commun/statut_demande_celebrite.html.twig'))
            ->add('dateDemande', 'array', array('label' => "Date de la demande", 'template'=> '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('dateReponse','array', array('label' => "Date de la réponse",'template'=> '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'delete' => array(),
                    'reponse' => array('template' => '@ath_admin_path/Commun/reponse_demande_celebrite.html.twig')
                )
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
            ->add('createdBy','text', array('label' => "Créé par"))
        ;
    }

    public function getExportFormats()
    {
        return array(
            'csv'
        );
    }
}
