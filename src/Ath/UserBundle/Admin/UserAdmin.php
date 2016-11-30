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
            : 'Création d\' un utilisateur'; // shown in the breadcrumb on the create view
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
            // ->add('statutJuridique')
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
        $formMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
            ->add('facebookId')
            ->add('facebookAccessToken')
            ->add('googleId')
            ->add('twitterId')
            ->add('nom')
            ->add('prenom')
            ->add('siteWeb')
            ->add('dateDeNaissance')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('photoId')
            ->add('photoExtension')
            ->add('photoOriginalName')
            ->add('rue')
            ->add('ville')
            ->add('cp')
            ->add('description')
            ->add('cgu')
            ->add('statutJuridique')
            ->add('dateDeCreation')
            ->add('isCelebrite')
            ->add('email')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
            ->add('facebookId')
            ->add('facebookAccessToken')
            ->add('googleId')
            ->add('twitterId')
            ->add('nom')
            ->add('prenom')
            ->add('siteWeb')
            ->add('dateDeNaissance')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('photoId')
            ->add('photoExtension')
            ->add('photoOriginalName')
            ->add('rue')
            ->add('ville')
            ->add('cp')
            ->add('description')
            ->add('cgu')
            ->add('statutJuridique')
            ->add('dateDeCreation')
            ->add('isCelebrite')
            ->add('email')
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
            'csv'
        );
    }
}
