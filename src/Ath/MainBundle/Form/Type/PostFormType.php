<?php

namespace Ath\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu', 'textarea', array('attr' => array('class' => 'form-control', 'placeholder' => 'placeholder.new_post')))
            ->add('file', 'file', array(
                'required' => false,
                'multiple' => false,
                'attr' => array('class' => 'hidden'),
            ))
            ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ath\MainBundle\Entity\Post',
            'translation_domain' => 'home',
        ));
    }
}
