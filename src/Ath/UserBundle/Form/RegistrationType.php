<?php

namespace Ath\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statutJuridique', 'choice', array(
                'choices' => array(0 => "Un homme", 1 => 'Une femme', 2 => 'Une association'),
                'required' => true,
                'label' => 'form.genre',
                'empty_data'  => null,
                'translation_domain' => "fosuser",
                'expanded' => true))

           ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle','attr' => array('placeholder' => 'form.email')))
         /*   ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle', 'required' => false))*/
            
            ->add('nom', 'text', array('label' => 'nom', 'attr' => array('placeholder' => 'nom'), 'translation_domain' => 'fosuser'))
            
            ->add('prenom', 'text', array('label' => 'registration.prenom', 'required' => false, 'attr' => array('placeholder' => 'prenom'), 'translation_domain' => 'fosuser'))

            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'fosuser'),
                'first_options' => array('label' => 'form.password','attr' => array('placeholder' => 'form.password')),
                'second_options' => array('label' => 'form.password_confirmation','attr' => array('placeholder' => 'form.password_confirmation')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))

            ->add('dateDeNaissance','date',array(
                'label' => 'registration.dateDeNaissance',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
                'years' => range(Date('Y')-16, 1930),
                'required' => false,
                'translation_domain' => 'fosuser'
            ))

            ->add('dateDeCreation','date',array(
                'label' => 'registration.dateDeCreation',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
                'years' => range(Date('Y')-16, 1930),
                'required' => false,
                'translation_domain' => 'fosuser'
            ))
        ;

        $builder->remove('username');
    }

    public function getParent()
    {
        // return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        return 'fos_user_registration';
    }
    
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}