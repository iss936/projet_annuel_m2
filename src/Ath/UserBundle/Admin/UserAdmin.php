<?php

namespace Ath\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{

    protected $baseRoutePattern = 'utilisateurs';

    public function toString($object)
    {
        return  $object->getId()
            ? $object
            : 'Création d\'un utilisateur'; // shown in the breadcrumb on the create view
    }

    /**
     * [configure permet de charger le js et le css nécessaire pour les pages create/edit/list]
     * @return Void
     */
    public function configure() {
        $this->setTemplate('edit', '@ath_admin_path/Commun/user_edit_javascript.html.twig');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('prenom')
            ->add('ville')
            ->add('statutJuridique', null, array('required' => false), 'statuts_juridique_widget')
            ->add('isCelebrite', 'doctrine_orm_choice', array('label' => 'Célébrité',
                    'field_options' => array(
                        'required' => false,
                        'choices' => array("1" => "Oui","0" => "Non")
                    ),
                    'field_type' => 'choice'
                ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('photoId','array', array('label' => "Photo",'template'=> '@ath_admin_path/Commun/image.html.twig'))
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('description')
            ->add('isCelebrite', null, array('label' => 'Célébrité'))
            ->add('statutJuridique')
            ->add('enabled', null, array('label' => "Activé"))
            ->add('lastLogin','array', array('label' => "Dernière connexion",'template'=> '@ath_admin_path/Commun/list_date.html.twig'))
            // ->add('roles')
            ->add('rue')
            ->add('ville')
            ->add('cp')
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
        $user = $this->getSubject();
        $id = $this->getRequest()->get($this->getIdParameter());

        $formMapper
            ->add('file', 'image', array(
                'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                'label' => 'Photo',
                'required' => false,
                'image_web_path' => ($id && is_object($user)) ? $this->getRequest()->getBasePath().'/'.$user->getWebPath() : ''// affiche
            ))
            ->add('email')

            ->add('statutJuridique', 'statuts_juridique_widget', array('label' => 'Statut Juridique', 'data' => $user->getStatutJuridiqueId()))
            ->add('enabled', null, array('label' => 'Activé'))
            // ->add('roles')
            ->add('nom')
            ->add('prenom', null, array('label' => 'Prenom *', 'required' => false, "attr" => array('class' => 'prenom')))
            ->add('dateDeNaissance','date',array(
                'label' => 'Date de Naissance *',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years' => range(Date('Y') - 13, 1930),
                'required' => false,
                "attr" => array('class' => 'dateDeNaissance', 'data-id' => 'dateDeNaissance')
            ))
            ->add('description')
            ->add('rue')
            ->add('ville', null, array('required' => true))
            ->add('cp')
            ->add('userInteretSports', null, array('required' => true, 'label' => 'Sport qui suscite votre intérêt ?'))
            ->add('isCelebrite', null, array('label' => 'Célébrité', 'required' => false, "attr" => array('class' => 'celebrite', 'data-id' => 'celebrite')))

             ->add('dateDeCreation','date',array(
                'label' => 'Date de Création  *',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years' => range(Date('Y'), 1850),
                'required' => false,
                "attr" => array('class' => 'dateDeCreation', 'data-id' => 'dateDeCreation')
            ))
            ->add('siteWeb', null, array('label' => 'Url site web', 'required' => false, "attr" => array('class' => 'siteWeb')))
            ->add('associationSports', null, array('label' => 'Sport pratiqué au sein de l\'association *', 'required' => false, "attr" => array('class' => 'siteWeb')))

        ;
    }

    public function prePersist($object)
    {
        $associationRoles = array('ROLE_USER','ROLE_ASSOC');
        $celebriteRoles = array('ROLE_USER','ROLE_CELEBRITE');
        $userRoles = array('ROLE_USER');
        $object->setPlainPassword(uniqid());
        if($object->getStatutJuridiqueId() == 3)
            $object->setRoles($associationRoles);
        else{
            if($object->getIsCelebrite())
                $object->setRoles($celebriteRoles);
            else
                $object->setRoles($userRoles);
        }
    }

    public function preUpdate($object)
    {
        $associationRoles = array('ROLE_USER','ROLE_ASSOC');
        $celebriteRoles = array('ROLE_USER','ROLE_CELEBRITE');
        $userRoles = array('ROLE_USER');

        if($object->getStatutJuridiqueId() == 3)
            $object->setRoles($associationRoles);
        else{
            if($object->getIsCelebrite())
                $object->setRoles($celebriteRoles);
            else
                $object->setRoles($userRoles);
        }
    }
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $user = $this->getSubject();
        $id = $this->getRequest()->get($this->getIdParameter());
        // on a une assoc
        if ($user->getStatutJuridiqueId() == 3) {
            $showMapper
                ->add('file', 'array', array(
                    'label' => "Photo",
                    'template' => '@ath_admin_path/Commun/show_image.html.twig'
                ))
                ->add('email')

                ->add('statutJuridique')
                ->add('enabled', null, array('label' => 'Activé'))
                // ->add('roles')
                ->add('nom')
                // ->add('prenom')
                // ->add('dateDeNaissance', 'array', array('template' => '@ath_admin_path/Commun/list_date.html.twig'))
                ->add('description')
                ->add('rue')
                ->add('ville')
                ->add('cp')
                ->add('userInteretSports', null, array('label' => 'Sport qui suscite votre intérêt ?'))
                // ->add('isCelebrite', null, array('label' => 'Célébrité'))
                ->add('dateDeCreation', 'array', array('template' => '@ath_admin_path/Commun/list_date.html.twig'))
                ->add('siteWeb', null, array('label' => 'Url site web'))
                ->add('associationSports', null, array('label' => 'Sport pratiqué au sein de l\'association *'))
        ;
        }
        else{
            $showMapper
                ->add('file', 'array', array(
                    'label' => "Photo",
                    'template' => '@ath_admin_path/Commun/show_image.html.twig'
                ))
                ->add('email')

                ->add('statutJuridique')
                ->add('enabled', null, array('label' => 'Activé'))
                // ->add('roles')
                ->add('nom')
                ->add('prenom')
                ->add('dateDeNaissance', 'array', array('template' => '@ath_admin_path/Commun/list_date.html.twig'))
                ->add('description')
                ->add('rue')
                ->add('ville')
                ->add('cp')
                ->add('userInteretSports', null, array('label' => 'Sport qui suscite votre intérêt ?'))
                ->add('isCelebrite', null, array('label' => 'Célébrité'))
                // ->add('dateDeCreation', 'array', array('template' => '@ath_admin_path/Commun/list_date.html.twig'))
                // ->add('siteWeb', null, array('label' => 'Url site web'))
                // ->add('associationSports', null, array('label' => 'Sport pratiqué au sein de l\'association *'))
            ;
        }
        
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
            'csv'
        );
    }
}
