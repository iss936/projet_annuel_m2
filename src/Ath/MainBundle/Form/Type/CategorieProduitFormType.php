<?php

namespace Ath\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieProduitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorieProduit', 'entity', array(
            'class' => 'AthMainBundle:CategorieProduit',
            'label' => false,
            'empty_value' => true,
            'multiple' => true,
            'required' => false,
            'attr' => array('class' => 'selectpicker'),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.libelle', 'ASC');
            }
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ath\MainBundle\Form\Model\FiltreCategorieProduit',
            'translation_domain' => 'home'
        ));
    }
}
