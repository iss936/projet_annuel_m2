<?php

namespace Ath\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EditProfileAssocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('label' => 'nom', 'attr' => array('class'=>'form-control', 'placeholder' => 'nom')))

            ->add('dateDeCreation','date',array(
                'label' => 'edit.dateDeCreation',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
                'years' => range(Date('Y'), 1850),
                // 'required' => false,
            ))
            ->add('rue', 'text', array('label' => 'label.rue', 'required' => true, 'attr' => array('class'=>'form-control', 'placeholder' => 'placeholder.rue')))
            ->add('ville', 'text', array('label' => 'label.ville', 'required' => true,'attr' => array('class'=>'form-control', 'placeholder' => 'placeholder.ville')))
            ->add('cp', 'text', array('label' => 'label.cp', 'required' => true, 'attr' => array('class'=>'form-control', 'placeholder' => 'placeholder.cp')))
            ->add('description', 'textarea', array('label' => 'label.cp','required' => false, 'attr' => array('class'=>'form-control', 'placeholder' => 'placeholder.cp')))
            ->add('file', 'file', array('data_class' => 'Symfony\Component\HttpFoundation\File\File','label' => 'formEditProfile.photo', 'required' => false))
            ->add('description', 'textarea', array('label' => 'label.description','required' => false, 'attr' => array('class'=>'form-control', 'placeholder' => 'placeholder.description')))
            ->add('siteWeb', 'text', array('label' => 'edit.siteWeb','required' => false, 'attr' => array('class'=>'form-control', 'placeholder' => 'edit.siteWeb')))
            ->add('associationSports', 'entity', array('class' => 'AthMainBundle:Sport',
                'multiple' => true,
                'expanded' => false,
                'required' => true,
                'label' => 'edit.associationSports',
                'empty_value' => true,
                'attr' => array('class'=>'selectpicker'),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC');
                }))
            ->add('userInteretSports', 'entity', array('class' => 'AthMainBundle:Sport',
                'multiple' => true,
                'expanded' => false,
                'required' => true,
                'label' => 'edit.userInterets',
                'empty_value' => true,
                'attr' => array('class'=>'selectpicker'),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC');
                }))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Ath\UserBundle\Entity\User',
            'translation_domain' => 'fosuser',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ath_edit_profile_assoc';
    }
}