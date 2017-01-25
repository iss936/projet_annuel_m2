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
        ))->add('prix', 'choice', array(
            'choices' => array('0' => 'Tous', '1' => '0 à 99€', '2' => '100 à 499€', '3' => 'plus de 500 €'),
            'label' => false,
            'expanded' => false,
            'multiple' => false
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