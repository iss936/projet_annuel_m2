<?php

namespace Ath\MainBundle\Form\WidgetType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;


class ImageType extends AbstractType
{

    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'image';
    } 

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'image_web_path'         => ''
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['image_web_path'] = $options['image_web_path'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->setAttribute('image_web_path', $options['image_web_path'])
        ;
    }
}