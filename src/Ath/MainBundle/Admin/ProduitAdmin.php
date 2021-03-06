<?php

namespace Ath\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Security\Core\SecurityContextInterface;

class ProduitAdmin extends Admin
{

    private $em;

    protected $baseRoutePattern = 'produit';

    protected $securityContext;

    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;

    }
    
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
            ->add('categorieProduit')
        ;
    }

    /**
     * createQuery permet d'override la requête qui liste les produits
     * @param  string $context
     * @return Array of collection of produuit
     */
    public function createQuery($context = 'list')
    {
        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        //if is logged admin, show all data
        if ($this->securityContext->isGranted('ROLE_ADMIN_PRODUIT')) {
            $queryBuilder->select('p')
                    ->from($this->getClass(), 'p')
             ;
        }
        else // Pour les autres on affiche la liste des produits dont ils sont auteur (createdBy)
        {
            $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
            $queryBuilder->select('p')
                    ->from($this->getClass(), 'p')
                    ->where('p.createdBy = :createdBy')
                    ->setParameter('createdBy', $user)
            ;
        }

        $proxyQuery = new ProxyQuery($queryBuilder);
        return $proxyQuery;
    }
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('fileProduits', 'array', array('label' => "Photo",'template' => '@ath_admin_path/Commun/produit_first_image.html.twig'))
            ->add('categorieProduit')
            ->add('libelle')
            ->add('description', 'text', array('template' => '@ath_admin_path/Commun/list_sub_string.html.twig'))
            ->add('createdBy',null, array('label' => "Créé par"))
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
                'required' => true,
                'by_reference' => false,
                'cascade_validation' => true,
                'label' => 'Photos'
            ), array(
                        'edit' => 'inline',
                        'inline' => 'table'
            ))
            ->add('categorieProduit', null, array("required" => true))
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
            ->add('createdBy',null, array('label' => "Créé par"))
            ->add('createdAt', 'array', array('label' => "Créé le", 'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('updatedAt','array', array('label' => "Modifié le",'template' => '@ath_admin_path/Commun/list_date.html.twig'))
            ->add('prix','array', array('template' => '@ath_admin_path/Commun/list_money.html.twig'))
            ->add('url','text', array('label' => "Lien d'achat"))
            ->add('fileProduits','array', array('label' => "Photos",'template' => '@ath_admin_path/Commun/collection_produit_images.html.twig'))
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

        foreach ($object->getFileProduits() as $image) {
           $image->setProduit($object);
        }

        return $object;
    }

    public function preUpdate($object)
    {
        foreach ($object->getFileProduits() as $image) {
           $image->setProduit($object);
        }
        return $object;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->assertCallback(array('postControl'))
        ;
    }    
}
