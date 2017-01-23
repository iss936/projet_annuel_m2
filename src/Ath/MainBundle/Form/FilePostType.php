<?php

namespace Ath\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilePostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','file')
        ;
    }
    
    public function getName()
    {
        return "fileposttype";
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ath\MainBundle\Entity\FilePost',
            'csrf_protection'=> true,
            'csrf_field_name'=>'_token',
            'intention'=>'file'
        ));
    }
}
