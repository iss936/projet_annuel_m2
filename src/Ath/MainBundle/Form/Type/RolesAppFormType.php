<?php

namespace Ath\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ath\MainBundle\Form\DataTransformer\RolesAppFormDataTransformer;

class RolesAppFormType extends AbstractType
{
    private $roles;
    private $multiple;
    private $expanded;


    public function __construct(array $roles, $multiple, $expanded)
    {
        $this->roles = $roles;
        $this->multiple = $multiple;
        $this->expanded = $expanded;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new RolesAppFormDataTransformer();
        $builder->add('roles', 'choice', array(
            'choices'   => $this->roles,
            'label'     => false,
            'required'  => false,
            'multiple'  => $this->multiple,
            'expanded'  => $this->expanded
        ))->addModelTransformer($transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // $resolver->setDefaults(array(
        //     'multiple'  => true,
        //     'expanded'  => true
        // ));

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'roles_app';
    }
}
