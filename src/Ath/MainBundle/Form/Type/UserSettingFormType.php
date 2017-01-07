<?php

namespace Ath\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSettingFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('autoFollow')
            ->add('mailWhenFollower', 'choice', array('choices'  => array(
                1 => "choice.oui",
                0 => "choice.non",
                ),
                'data' => $builder->getData()->getMailWhenFollower(),
                'attr' => array('class' => 'form-control'),
                'label' => 'label.mailWhenFollower'
                )                
            )
            ->add('newsletter', 'choice', array('choices'  => array(
                1 => "choice.oui",
                0 => "choice.non",
                ),
                'data' => $builder->getData()->getNewsletter(),
                'attr' => array('class' => 'form-control'),
                'label' => 'label.newsletter'
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ath\MainBundle\Entity\UserSetting',
            'translation_domain' => 'home'
        ));
    }
}
