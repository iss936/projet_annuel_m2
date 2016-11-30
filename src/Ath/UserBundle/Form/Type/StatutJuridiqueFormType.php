<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ath\UserBundle\Form\DataTransformer\StatutJuridiqueDataTransformer;
use Ath\UserBundle\Model\StatutJuridique;

class StatutJuridiqueFormType extends AbstractType
{
    private $statuts;

    public function __construct()
    {
        $this->statuts = StatutJuridique::getAll();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StatutJuridiqueDataTransformer();
        $builder->add('statuts', 'choice', array(
            'choices'  => $this->statuts,
            'label'    => false,
            'required' => true,
            'empty_value' => "",
            'multiple' => false
        ))->addModelTransformer($transformer);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        // $resolver->setDefaults(array(
        //     'data_class' => '',
        // ));
    }

    public function getName()
    {
        return 'statuts_juridique_widget';
    }
}
