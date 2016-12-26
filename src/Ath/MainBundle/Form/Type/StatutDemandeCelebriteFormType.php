<?php

namespace Ath\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ath\MainBundle\Form\DataTransformer\StatutDemandeCelebriteDataTransformer;
use Ath\MainBundle\Model\StatutDemandeCelebrite;

class StatutDemandeCelebriteFormType extends AbstractType
{
    private $statuts;

    public function __construct()
    {
        $this->statuts = StatutDemandeCelebrite::getAll();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StatutDemandeCelebriteDataTransformer();
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
        return 'statuts_demande_celebrite_widget';
    }
}
